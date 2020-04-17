<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Html\Html;

final class TextArea extends Widget
{
    private string $charset = 'UTF-8';

    /**
     * Generates a textarea tag for the given form attribute.
     *
     * @return string the generated textarea tag.
     */
    public function run(): string
    {
        $name = $this->options['name'] ?? BaseForm::getInputName($this->form, $this->attribute);
        $id = $this->options['id'] ?? $this->id;

        if (isset($this->options['value'])) {
            $value = $this->options['value'];
            unset($this->options['value']);
        } else {
            $value = BaseForm::getAttributeValue($this->form, $this->attribute);
        }

        if ($id === null) {
            $this->options['id'] = BaseForm::getInputId($this->form, $this->attribute, $this->charset);
        }


        BaseForm::placeHolder($this->form, $this->attribute, $this->options);

        return Html::textarea($name, $value, $this->options);
    }

    public function charset(string $value): self
    {
        $this->charset = $value;

        return $this;
    }
}
