<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Html\Html;

final class BooleanInput extends Widget
{
    private string $charset = 'UTF-8';
    private bool $label = true;
    private bool $uncheck = false;
    private ?string $type = null;

    /**
     * Generates a boolean input.
     *
     * This method is mainly called by {@see CheckboxForm} and {@see RadioForm}.
     *
     * @return string the generated input element.
     */
    public function run(): string
    {
        $name = $this->options['name'] ?? BaseForm::getInputName($this->form, $this->attribute);
        $value = BaseForm::getAttributeValue($this->form, $this->attribute);

        if (!array_key_exists('value', $this->options)) {
            $this->options['value'] = '1';
        }

        if ($this->uncheck) {
            $this->options['uncheck'] = '0';
        } else {
            unset($this->options['uncheck']);
        }

        if ($this->label) {
            $this->options['label'] = Html::encode(
                $this->form->getAttributeLabel(
                    BaseForm::getAttributeName($this->attribute)
                )
            );
        }

        $this->options['id'] = $this->id;

        if ($this->id === null) {
            $this->options['id'] = BaseForm::getInputId($this->form, $this->attribute, $this->charset);
        }

        $type = $this->type;

        return Html::$type($name, $value, $this->options);
    }

    public function charset(string $value): self
    {
        $this->charset = $value;

        return $this;
    }

    public function label(bool $value): self
    {
        $this->label = $value;

        return $this;
    }

    public function uncheck(bool $value): self
    {
        $this->uncheck = $value;

        return $this;
    }

    public function type(string $value): self
    {
        $this->type = $value;

        return $this;
    }
}
