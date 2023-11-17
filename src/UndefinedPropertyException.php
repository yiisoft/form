<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use InvalidArgumentException;

final class UndefinedPropertyException extends InvalidArgumentException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function forUndefinedProperty(string $property): self
    {
        return new self('Undefined property: "' . $property . '".');
    }

    public static function forNotNestedProperty(string $property): self
    {
        return new self('Property "' . $property . '" is not a nested attribute.');
    }
}
