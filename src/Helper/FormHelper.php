<?php

declare(strict_types=1);

namespace Yiisoft\Form\Helper;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Strings\Inflector;
use Yiisoft\Strings\StringHelper;

use function array_key_exists;
use function array_slice;
use function is_array;
use function is_object;

/**
 * @internal
 */
final class FormHelper
{
    private const META_LABEL = 1;
    private const META_HINT = 2;
    private const META_PLACEHOLDER = 3;

    private static ?Inflector $inflector = null;

    /**
     * @throws InvalidAttributeException
     */
    public static function getValue(FormModelInterface $form, string $attribute): mixed
    {
        $path = self::normalizePath($attribute);

        $value = $form;
        $keys = [[$form::class, $form]];
        foreach ($path as $key) {
            $keys[] = [$key, $value];

            if (is_array($value)) {
                if (array_key_exists($key, $value)) {
                    /** @var mixed $value */
                    $value = $value[$key];
                    continue;
                }
                throw self::createNotFoundException($keys);
            }

            if (is_object($value)) {
                $class = new ReflectionClass($value);
                try {
                    $property = $class->getProperty($key);
                } catch (ReflectionException) {
                    throw self::createNotFoundException($keys);
                }
                if ($property->isStatic()) {
                    throw self::createNotFoundException($keys);
                }
                /** @var mixed $value */
                $value = $property->getValue($value);
                continue;
            }

            array_pop($keys);
            throw new InvalidAttributeException(
                sprintf('Attribute "%s" is not a nested attribute.', self::makePathString($keys))
            );
        }

        return $value;
    }

    public static function hasAttribute(FormModelInterface $form, string $attribute): bool
    {
        try {
            self::getValue($form, $attribute);
        } catch (InvalidAttributeException) {
            return false;
        }
        return true;
    }

    public static function getAttributeLabel(FormModelInterface $form, string $attribute): string
    {
        return self::getAttributeMetaValue(self::META_LABEL, $form, $attribute)
            ?? self::generateAttributeLabel($attribute);
    }

    public static function getAttributeHint(FormModelInterface $form, string $attribute): string
    {
        return self::getAttributeMetaValue(self::META_HINT, $form, $attribute) ?? '';
    }

    public static function getAttributePlaceholder(FormModelInterface $form, string $attribute): string
    {
        return self::getAttributeMetaValue(self::META_PLACEHOLDER, $form, $attribute) ?? '';
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
    private static function generateAttributeLabel(string $attribute): string
    {
        if (self::$inflector === null) {
            self::$inflector = new Inflector();
        }

        return StringHelper::uppercaseFirstCharacterInEachWord(
            self::$inflector->toWords($attribute)
        );
    }

    private static function getAttributeMetaValue(int $metaKey, FormModelInterface $form, string $attribute): ?string
    {
        $path = self::normalizePath($attribute);

        $value = $form;
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
     * @return string[]
     */
    private static function normalizePath(string $attribute): array
    {
        $attribute = str_replace(['][', '['], '.', rtrim($attribute, ']'));
        return StringHelper::parsePath($attribute);
    }

    /**
     * @psalm-param list<array{0:int|string, 1:mixed}> $keys
     */
    private static function createNotFoundException(array $keys): InvalidArgumentException
    {
        return new InvalidAttributeException('Undefined property: "' . self::makePathString($keys) . '".');
    }

    /**
     * @psalm-param list<array{0:int|string, 1:mixed}> $keys
     */
    private static function makePathString(array $keys): string
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
