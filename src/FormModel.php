<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use Vjik\InputValidation\ValidatedModelTrait;
use Yiisoft\Strings\Inflector;
use Yiisoft\Strings\StringHelper;
use Yiisoft\Validator\Result;

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
    use ValidatedModelTrait;

    private const META_LABEL = 1;
    private const META_HINT = 2;
    private const META_PLACEHOLDER = 3;

    private static ?Inflector $inflector = null;

    public function getAttributeHint(string $attribute): string
    {
        return $this->readAttributeMetaValue(self::META_HINT, $attribute) ?? '';
    }

    public function getAttributeHints(): array
    {
        return [];
    }

    public function getAttributeLabel(string $attribute): string
    {
        return $this->readAttributeMetaValue(self::META_LABEL, $attribute) ?? $this->generateAttributeLabel($attribute);
    }

    public function getAttributeLabels(): array
    {
        return [];
    }

    public function getAttributePlaceholder(string $attribute): string
    {
        return $this->readAttributeMetaValue(self::META_PLACEHOLDER, $attribute) ?? '';
    }

    public function getAttributePlaceholders(): array
    {
        return [];
    }

    public function getAttributeValue(string $attribute): mixed
    {
        return $this->readAttributeValue($attribute);
    }

    /**
     * @return string Returns classname without a namespace part or empty string when class is anonymous
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

    public function hasAttribute(string $attribute): bool
    {
        try {
            $this->readAttributeValue($attribute);
        } catch (InvalidAttributeException) {
            return false;
        }
        return true;
    }

    public function processValidationResult(Result $result): void
    {
        $this->validationResult = $result;
    }

    public function isValidated(): bool
    {
        return $this->validationResult !== null;
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
            if ($value instanceof FormModelInterface) {
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
