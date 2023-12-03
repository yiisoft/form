<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\ValidationClass;

final class ValidationClassField extends BaseValidationClass
{
    protected function generateInput(): string
    {
        $attributes = [];
        $this->addValidationClassToAttributes($attributes, $this->getInputData());

        $inputAttributes = [];
        $this->addInputValidationClassToAttributes($inputAttributes, $this->getInputData());

        return '<b>' . implode("\n", [$attributes['class'] ?? '', $inputAttributes['class'] ?? '']) . '</b>';
    }
}
