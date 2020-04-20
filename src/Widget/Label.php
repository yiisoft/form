<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

final class Label extends Widget
{
    private string $charset = 'UTF-8';

    /**
     * Generates a label tag for the given form attribute.
     *
     * @return string the generated label tag.
     */
    public function run(): string
    {
        $for = ArrayHelper::remove(
            $this->options,
            'for',
            BaseForm::getInputId($this->form, $this->attribute, $this->charset)
        );

        $label = ArrayHelper::remove(
            $this->options,
            'label',
            Html::encode($this->form->getAttributeLabel($this->attribute))
        );

        return Html::label($label, $for, $this->options);
    }

    public function charset(string $value): self
    {
        $this->charset = $value;

        return $this;
    }
}
