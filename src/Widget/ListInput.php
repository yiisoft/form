<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

final class ListInput extends Widget
{
    private string $charset = 'UTF-8';
    private bool $multiple = false;
    private array $items = [];
    private string $type;
    private ?string $unselect = null;

    /**
     * Generates a list of input fields.
     *
     * This method is mainly called by {@see ListBox()}, {@see RadioList()} and {@see CheckboxList()}.
     *
     * @return string the generated input list
     */
    public function run(): string
    {
        $name = ArrayHelper::remove($this->options, 'name', BaseForm::getInputName($this->form, $this->attribute));
        $selection = ArrayHelper::remove(
            $this->options,
            'value',
            BaseForm::getAttributeValue($this->form, $this->attribute)
        );

        if (!empty($this->unselect)) {
            $this->options['unselect'] = '';
        } else {
            $this->options['unselect'] = $this->unselect;
        }

        $this->options['id'] = $this->id;

        if ($this->id === null) {
            $this->options['id'] = BaseForm::getInputId($this->form, $this->attribute, $this->charset);
        }

        if ($this->multiple) {
            $this->options['multiple'] = $this->multiple;
        }

        $type = $this->type;

        return Html::$type($name, $selection, $this->items, $this->options);
    }

    public function charset(string $value): self
    {
        $this->charset = $value;

        return $this;
    }

    public function multiple(bool $value): self
    {
        $this->multiple = $value;

        return $this;
    }

    public function items(array $value): self
    {
        $this->items = $value;

        return $this;
    }

    public function type(string $value): self
    {
        $this->type = $value;

        return $this;
    }

    public function unselect(?string $value): self
    {
        $this->unselect = $value;

        return $this;
    }
}
