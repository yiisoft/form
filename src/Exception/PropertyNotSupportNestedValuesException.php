<?php

declare(strict_types=1);

namespace Yiisoft\Form\Exception;

final class PropertyNotSupportNestedValuesException extends ValueNotFoundException
{
    public function __construct(string $property, private mixed $value)
    {
        parent::__construct('Property "' . $property . '" is not a nested attribute.');
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}
