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
        if (ArrayHelper::keyExists($this->fields, $attribute)) {
            return true;
        }

        return parent::hasAttribute($attribute);
    }

    public function getAttributeValue(string $attribute)
    {
        if (ArrayHelper::keyExists($this->fields, $attribute)) {
            return $this->fields[$attribute];
        }

        return parent::getAttributeValue();
    }

    public function setAttribute(string $name, $value): void
    {
        if (ArrayHelper::keyExists($this->fields, $name)) {
            $this->fields[$name] = $value;
        } else {
            parent::setAttribute($name, $value);
        }
    }
}
