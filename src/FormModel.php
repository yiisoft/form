<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use Vjik\InputValidation\ValidatedModelInterface;
use Vjik\InputValidation\ValidatedModelTrait;
use Yiisoft\Strings\Inflector;
use Yiisoft\Strings\StringHelper;

use function array_key_exists;
use function array_slice;
use function is_array;
use function is_object;
use function str_contains;
use function strrchr;
use function substr;

/**
 * Form model represents an HTML form: its data, validation and presentation.
 */
abstract class FormModel implements ValidatedModelInterface
{
    use ValidatedModelTrait;

    private const META_LABEL = 1;
    private const META_HINT = 2;
    private const META_PLACEHOLDER = 3;

    private static ?Inflector $inflector = null;

    /**
     * Returns the text hint for the specified attribute.
     *
     * @param string $attribute the attribute name.
     *
     * @return string the attribute hint.
     */
    public function getAttributeHint(string $attribute): string
    {
        return $this->readAttributeMetaValue(self::META_HINT, $attribute) ?? '';
    }

    /**
     * Returns the attribute hints.
     *
     * Attribute hints are mainly used for display purpose. For example, given an attribute `isPublic`, we can declare
     * a hint `Whether the post should be visible for not logged-in users`, which provides user-friendly description of
     * the attribute meaning and can be displayed to end users.
     *
     * Unlike label hint will not be generated, if its explicit declaration is omitted.
     *
     * Note, in order to inherit hints defined in the parent class, a child class needs to merge the parent hints with
     * child hints using functions such as `array_merge()`.
     *
     * @return array attribute hints (name => hint)
     *
     * @psalm-return array<string,string>
     */
    public function getAttributeHints(): array
    {
        return [];
    }

    /**
     * Returns the text label for the specified attribute.
     *
     * @param string $attribute The attribute name.
     *
     * @return string The attribute label.
     */
    public function getAttributeLabel(string $attribute): string
    {
        return $this->readAttributeMetaValue(self::META_LABEL, $attribute) ?? $this->generateAttributeLabel($attribute);
    }

    /**
     * Returns the attribute labels.
     *
     * Attribute labels are mainly used for display purpose. For example, given an attribute `firstName`, we can
     * declare a label `First Name` which is more user-friendly and can be displayed to end users.
     *
     * By default, an attribute label is generated automatically. This method allows you to
     * explicitly specify attribute labels.
     *
     * Note, in order to inherit labels defined in the parent class, a child class needs to merge the parent labels
     * with child labels using functions such as `array_merge()`.
     *
     * @return array attribute labels (name => label)
     *
     * {@see \Yiisoft\Form\FormModel::getAttributeLabel()}
     *
     * @psalm-return array<string,string>
     */
    public function getAttributeLabels(): array
    {
        return [];
    }

    /**
     * Returns the text placeholder for the specified attribute.
     *
     * @param string $attribute the attribute name.
     *
     * @return string the attribute placeholder.
     */
    public function getAttributePlaceholder(string $attribute): string
    {
        return $this->readAttributeMetaValue(self::META_PLACEHOLDER, $attribute) ?? '';
    }

    public function getAttributeValue(string $attribute): mixed
    {
        return $this->readAttributeValue($attribute);
    }

    /**
     * Returns the attribute placeholders.
     *
     * @return array attribute placeholder (name => placeholder)
     *
     * @psalm-return array<string,string>
     */
    public function getAttributePlaceholders(): array
    {
        return [];
    }

    /**
     * Returns the form name that this model class should use.
     *
     * The form name is mainly used by {@see \Yiisoft\Form\Helper\HtmlForm} to determine how to name the input
     * fields for the attributes in a model.
     * If the form name is "A" and an attribute name is "b", then the corresponding input name would be "A[b]".
     * If the form name is an empty string, then the input name would be "b".
     *
     * The purpose of the above naming schema is that for forms which contain multiple different models, the attributes
     * of each model are grouped in sub-arrays of the POST-data, and it is easier to differentiate between them.
     *
     * By default, this method returns the model class name (without the namespace part) as the form name. You may
     * override it when the model is used in different forms.
     *
     * @return string The form name of this model class.
     */
    public function getFormName(): string
    {
        if (str_contains(static::class, '@anonymous')) {
            return '';
        }

        $className = strrchr(static::class, '\\');
        if ($className === false) {
            return static::class;
        }

        return substr($className, 1);
    }

    /**
     * If there is such attribute in the set.
     */
    public function hasAttribute(string $attribute): bool
    {
        try {
            $this->readAttributeValue($attribute);
        } catch (InvalidAttributeException) {
            return false;
        }
        return true;
    }

    public function isValid(): bool
    {
        return (bool) $this->getValidationResult()?->isValid();
    }

    /**
     * @throws InvalidAttributeException
     */
    private function readAttributeValue(string $attribute): mixed
    {
        $path = $this->normalizePath($attribute);

        $value = $this;
        $keys = [[static::class, $this]];
        foreach ($path as $key) {
            $keys[] = [$key, $value];

            if (is_array($value)) {
                if (array_key_exists($key, $value)) {
                    /** @var mixed $value */
                    $value = $value[$key];
                    continue;
                }
                throw $this->createNotFoundException($keys);
            }

            if (is_object($value)) {
                $class = new ReflectionClass($value);
                try {
                    $property = $class->getProperty($key);
                } catch (ReflectionException) {
                    throw $this->createNotFoundException($keys);
                }
                if ($property->isStatic()) {
                    throw $this->createNotFoundException($keys);
                }
                if (PHP_VERSION_ID < 80100) {
                    $property->setAccessible(true);
                }
                /** @var mixed $value */
                $value = $property->getValue($value);
                continue;
            }

            array_pop($keys);
            throw new InvalidAttributeException(
                sprintf('Attribute "%s" is not a nested attribute.', $this->makePathString($keys))
            );
        }

        return $value;
    }

    private function readAttributeMetaValue(int $metaKey, string $attribute): ?string
    {
        $path = $this->normalizePath($attribute);

        $value = $this;
        $n = 0;
        foreach ($path as $key) {
            if ($value instanceof self) {
                $nestedAttribute = implode('.', array_slice($path, $n));
                $data = match ($metaKey) {
                    self::META_LABEL => $value->getAttributeLabels(),
                    self::META_HINT => $value->getAttributeHints(),
                    self::META_PLACEHOLDER => $value->getAttributePlaceholders(),
                    default => throw new InvalidArgumentException('Invalid meta key.'),
                };
                if (array_key_exists($nestedAttribute, $data)) {
                    return $data[$nestedAttribute];
                }
            }

            $class = new ReflectionClass($value);
            try {
                $property = $class->getProperty($key);
            } catch (ReflectionException) {
                return null;
            }
            if ($property->isStatic()) {
                return null;
            }

            if (PHP_VERSION_ID < 80100) {
                $property->setAccessible(true);
            }
            /** @var mixed $value */
            $value = $property->getValue($value);
            if (!is_object($value)) {
                return null;
            }

            $n++;
        }

        return null;
    }

    /**
     * Generates a user-friendly attribute label based on the give attribute name.
     *
     * This is done by replacing underscores, dashes and dots with blanks and changing the first letter of each word to
     * upper case.
     *
     * For example, 'department_name' or 'DepartmentName' will generate 'Department Name'.
     *
     * @param string $attribute The attribute name.
     *
     * @return string The attribute label.
     */
    private function generateAttributeLabel(string $attribute): string
    {
        if (self::$inflector === null) {
            self::$inflector = new Inflector();
        }

        return StringHelper::uppercaseFirstCharacterInEachWord(
            self::$inflector->toWords($attribute)
        );
    }

    /**
     * @return string[]
     */
    private function normalizePath(string $attribute): array
    {
        $attribute = str_replace(['][', '['], '.', rtrim($attribute, ']'));
        return StringHelper::parsePath($attribute);
    }

    /**
     * @psalm-param array<array-key, array{0:int|string, 1:mixed}> $keys
     */
    private function createNotFoundException(array $keys): InvalidArgumentException
    {
        return new InvalidAttributeException('Undefined property: "' . $this->makePathString($keys) . '".');
    }

    /**
     * @psalm-param array<array-key, array{0:int|string, 1:mixed}> $keys
     */
    private function makePathString(array $keys): string
    {
        $path = '';
        foreach ($keys as $key) {
            if ($path !== '') {
                if (is_object($key[1])) {
                    $path .= '::' . $key[0];
                } elseif (is_array($key[1])) {
                    $path .= '[' . $key[0] . ']';
                }
            } else {
                $path = (string) $key[0];
            }
        }
        return $path;
    }
}
