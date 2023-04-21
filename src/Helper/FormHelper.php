<?php

declare(strict_types=1);

namespace Yiisoft\Form\Helper;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Strings\StringHelper;

use function array_key_exists;
use function is_array;
use function is_object;

/**
 * @internal
 */
final class FormHelper
{
    /**
     * @throws InvalidArgumentException
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
            throw new InvalidArgumentException(
                sprintf('Attribute "%s" is not a nested attribute.', self::makePathString($keys))
            );
        }

        return $value;
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
        return new InvalidArgumentException('Undefined property: "' . self::makePathString($keys) . '".');
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
