<?php

declare(strict_types=1);

namespace Yiisoft\Form\Exception;

final class UndefinedObjectPropertyException extends ValueNotFoundException
{
    public function __construct(string $property)
    {
        parent::__construct('Undefined object property: "' . $property . '".');
    }
}
