<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Html\Html;
use Yiisoft\Form\FormHtml;

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
        $name = $this->options['name'] ?? FormHTml::getInputName($this->data, $this->attribute);
        $id = $this->options['id'] ?? $this->id;

        if (isset($this->options['value'])) {
            $value = $this->options['value'];
            unset($this->options['value']);
        } else {
            $value = FormHTml::getAttributeValue($this->data, $this->attribute);
        }

        if ($id === null) {
            $this->options['id'] = FormHTml::getInputId($this->data, $this->attribute, $this->charset);
        }


        FormHTml::placeholder($this->data, $this->attribute, $this->options);

        return Html::textarea($name, $value, $this->options);
    }

    public function charset(string $value): self
    {
        $this->charset = $value;

        return $this;
    }
}
