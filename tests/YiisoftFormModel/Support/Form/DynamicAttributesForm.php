<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\YiisoftFormModel\Support\Form;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Form\YiisoftFormModel\FormModel;

final class DynamicAttributesForm extends FormModel
{
    public function __construct(private array $attributes = [])
    {
    }

    public function hasProperty(string $property): bool
    {
        return ArrayHelper::keyExists($this->attributes, $property);
    }

    public function getPropertyValue(string $property): mixed
    {
        if ($this->hasProperty($property)) {
            return $this->attributes[$property];
        }

        return null;
    }

    public function setAttribute(string $name, $value): void
    {
        if ($this->hasProperty($name)) {
            $this->attributes[$name] = $value;
        }
    }
}
