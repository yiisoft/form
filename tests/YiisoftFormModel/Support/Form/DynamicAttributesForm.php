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

    public function hasAttribute(string $attribute): bool
    {
        return ArrayHelper::keyExists($this->attributes, $attribute);
    }

    public function getAttributeValue(string $attribute): mixed
    {
        if ($this->hasAttribute($attribute)) {
            return $this->attributes[$attribute];
        }

        return null;
    }

    public function setAttribute(string $name, $value): void
    {
        if ($this->hasAttribute($name)) {
            $this->attributes[$name] = $value;
        }
    }
}
