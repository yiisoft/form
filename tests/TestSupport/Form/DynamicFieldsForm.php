<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Arrays\ArrayHelper;

final class DynamicFieldsForm extends FormModel
{
    private array $fields = [];

    public function __construct(array $fields = [])
    {
        $this->fields = $fields;

        parent::__construct();
    }

    public function hasAttribute(string $attribute): bool
    {
        return ArrayHelper::keyExists($this->fields, $attribute);
    }

    public function getAttributeValue(string $attribute)
    {
        if ($this->hasAttribute($attribute)) {
            return $this->fields[$attribute];
        }

        return null;
    }

    public function setAttribute(string $name, $value): void
    {
        if ($this->hasAttribute($name)) {
            $this->fields[$name] = $value;
        }
    }
}
