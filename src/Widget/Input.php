<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Html\Html;

final class Input extends Widget
{
    private string $charset = 'UTF-8';
    private string $type;

    /**
     * Generates an input tag for the given form attribute.
     *
     * @return string the generated input tag.
     */
    public function run(): string
    {
        $name = $this->options['name'] ?? BaseForm::getInputName($this->form, $this->attribute);
        $value = $this->options['value'] ?? BaseForm::getAttributeValue($this->form, $this->attribute);
        $this->options['id'] = $this->options['id'] ?? $this->id;

        if ($this->options['id'] === null) {
            $this->options['id'] = BaseForm::getInputId($this->form, $this->attribute, $this->charset);
        }

        BaseForm::placeholder($this->form, $this->attribute, $this->options);

        return Html::input($this->type, $name, $value, $this->options);
    }

    public function charset(string $value): self
    {
        $this->charset = $value;

        return $this;
    }

    public function type(string $value): self
    {
        $this->type = $value;

        return $this;
    }
}
