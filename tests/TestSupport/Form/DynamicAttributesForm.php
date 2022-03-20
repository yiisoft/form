<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Form\FormModel;

final class DynamicAttributesForm extends FormModel
{
    public function __construct(private array $attributes = [])
    {
    }

    public function hasAttribute(string $attribute, string ...$nested): bool
    {
        return ArrayHelper::keyExists($this->attributes, $attribute);
    }

    public function getAttributeValue(string $attribute, string ...$nested): mixed
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
