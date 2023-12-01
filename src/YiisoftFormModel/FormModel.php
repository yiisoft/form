<?php

declare(strict_types=1);

namespace Yiisoft\Form\YiisoftFormModel;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use Yiisoft\Form\YiisoftFormModel\Exception\PropertyNotSupportNestedValuesException;
use Yiisoft\Form\YiisoftFormModel\Exception\StaticObjectPropertyException;
use Yiisoft\Form\YiisoftFormModel\Exception\UndefinedArrayElementException;
use Yiisoft\Form\YiisoftFormModel\Exception\UndefinedObjectPropertyException;
use Yiisoft\Form\YiisoftFormModel\Exception\ValueNotFoundException;
use Yiisoft\Hydrator\Validator\ValidatedInputTrait;
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
abstract class FormModel implements FormModelInterface
{
    use ValidatedInputTrait;

    private const META_LABEL = 1;
    private const META_HINT = 2;
    private const META_PLACEHOLDER = 3;

    private static ?Inflector $inflector = null;

    /**
     * Returns the text hint for the specified property.
     *
     * @param string $property The property name.
     *
     * @return string The property hint.
     */
    public function getPropertyHint(string $property): string
    {
        return $this->readPropertyMetaValue(self::META_HINT, $property) ?? '';
    }

    /**
     * Returns the property hints.
     *
     * Property hints are mainly used for display purpose. For example, given a property `isPublic`, we can declare
     * a hint `Whether the post should be visible for not logged-in users`, which provides user-friendly description of
     * the property meaning and can be displayed to end users.
     *
     * Unlike label hint will not be generated, if its explicit declaration is omitted.
     *
     * Note, in order to inherit hints defined in the parent class, a child class needs to merge the parent hints with
     * child hints using functions such as `array_merge()`.
     *
     * @return array Property hints (name => hint)
     *
     * @psalm-return array<string,string>
     */
    public function getPropertyHints(): array
    {
        return [];
    }

    /**
     * Returns the text label for the specified property.
     *
     * @param string $property The property name.
     *
     * @return string The property label.
     */
    public function getPropertyLabel(string $property): string
    {
        return $this->readPropertyMetaValue(self::META_LABEL, $property) ?? $this->generatePropertyLabel($property);
    }

    /**
     * Returns the property labels.
     *
     * Attribute labels are mainly used for display purpose. For example, given a property `firstName`, we can
     * declare a label `First Name` which is more user-friendly and can be displayed to end users.
     *
     * By default, a property label is generated automatically. This method allows you to
     * explicitly specify property labels.
     *
     * Note, in order to inherit labels defined in the parent class, a child class needs to merge the parent labels
     * with child labels using functions such as `array_merge()`.
     *
     * @return array Property labels (name => label)
     *
     * @psalm-return array<string,string>
     */
    public function getPropertyLabels(): array
    {
        return [];
    }

    /**
     * Returns the text placeholder for the specified property.
     *
     * @param string $property The property name.
     *
     * @return string The property placeholder.
     */
    public function getPropertyPlaceholder(string $property): string
    {
        return $this->readPropertyMetaValue(self::META_PLACEHOLDER, $property) ?? '';
    }

    public function getPropertyValue(string $property): mixed
    {
        try {
            return $this->readPropertyValue($property);
        } catch (PropertyNotSupportNestedValuesException $exception) {
            return $exception->getValue() === null
                ? null
                : throw $exception;
        } catch (UndefinedArrayElementException) {
            return null;
        }
    }

    /**
     * Returns the property placeholders.
     *
     * @return array Property placeholders (name => placeholder)
     *
     * @psalm-return array<string,string>
     */
    public function getPropertyPlaceholders(): array
    {
        return [];
    }

    /**
     * Returns the form name that this model class should use.
     *
     * The form name is mainly used by {@see \Yiisoft\Form\InputData\HtmlForm} to determine how to name the input
     * fields for the properties in a model.
     * If the form name is "A" and a property name is "b", then the corresponding input name would be "A[b]".
     * If the form name is an empty string, then the input name would be "b".
     *
     * The purpose of the above naming schema is that for forms which contain multiple different models, the properties
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
     * If there is such property in the set.
     */
    public function hasProperty(string $property): bool
    {
        try {
            $this->readPropertyValue($property);
        } catch (ValueNotFoundException) {
            return false;
        }
        return true;
    }

    public function isValid(): bool
    {
        return (bool) $this->getValidationResult()?->isValid();
    }

    /**
     * @throws UndefinedArrayElementException
     * @throws UndefinedObjectPropertyException
     * @throws StaticObjectPropertyException
     * @throws PropertyNotSupportNestedValuesException
     * @throws ValueNotFoundException
     */
    private function readPropertyValue(string $path): mixed
    {
        $path = $this->normalizePath($path);

        $value = $this;
        $keys = [[static::class, $this]];
        foreach ($path as $key) {
            $keys[] = [$key, $value];

            if (is_array($value)) {
                if (array_key_exists($key, $value)) {
                    $value = $value[$key];
                    continue;
                }
                throw new UndefinedArrayElementException($this->makePropertyPathString($keys));
            }

            if (is_object($value)) {
                $class = new ReflectionClass($value);
                try {
                    $property = $class->getProperty($key);
                } catch (ReflectionException) {
                    throw new UndefinedObjectPropertyException($this->makePropertyPathString($keys));
                }
                if ($property->isStatic()) {
                    throw new StaticObjectPropertyException($this->makePropertyPathString($keys));
                }
                $value = $property->getValue($value);
                continue;
            }

            array_pop($keys);
            throw new PropertyNotSupportNestedValuesException($this->makePropertyPathString($keys), $value);
        }

        return $value;
    }

    private function readPropertyMetaValue(int $metaKey, string $path): ?string
    {
        $path = $this->normalizePath($path);

        $value = $this;
        $n = 0;
        foreach ($path as $key) {
            if ($value instanceof self) {
                $nestedAttribute = implode('.', array_slice($path, $n));
                $data = match ($metaKey) {
                    self::META_LABEL => $value->getPropertyLabels(),
                    self::META_HINT => $value->getPropertyHints(),
                    self::META_PLACEHOLDER => $value->getPropertyPlaceholders(),
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

            $value = $property->getValue($value);
            if (!is_object($value)) {
                return null;
            }

            $n++;
        }

        return null;
    }

    /**
     * Generates a user-friendly property label based on the give property name.
     *
     * This is done by replacing underscores, dashes and dots with blanks and changing the first letter of each word to
     * upper case.
     *
     * For example, 'department_name' or 'DepartmentName' will generate 'Department Name'.
     *
     * @param string $property The property name.
     *
     * @return string The property label.
     */
    private function generatePropertyLabel(string $property): string
    {
        if (self::$inflector === null) {
            self::$inflector = new Inflector();
        }

        return StringHelper::uppercaseFirstCharacterInEachWord(
            self::$inflector->toWords($property)
        );
    }

    /**
     * @return string[]
     */
    private function normalizePath(string $path): array
    {
        $path = str_replace(['][', '['], '.', rtrim($path, ']'));
        return StringHelper::parsePath($path);
    }

    /**
     * @psalm-param array<array-key, array{0:int|string, 1:mixed}> $keys
     */
    private function makePropertyPathString(array $keys): string
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
