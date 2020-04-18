<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;

final class DropDownList extends Widget
{
    private bool $multiple = false;
    private array $items = [];
    private ?string $unselect = '';

    /**
     * Generates a drop-down list for the given form attribute.
     *
     * The selection of the drop-down list is taken from the value of the form attribute.
     *
     * @throws InvalidConfigException
     *
     * @return string the generated drop-down list tag.
     */
    public function run(): string
    {
        if (!$this->multiple) {
            return ListInput::widget()
                ->type('dropDownList')
                ->form($this->form)
                ->attribute($this->attribute)
                ->items($this->items)
                ->options($this->options)
                ->unselect($this->unselect)
                ->run();
        }

        $this->options['multiple'] = 'true';

        return ListBox::widget()
            ->form($this->form)
            ->attribute($this->attribute)
            ->items($this->items)
            ->options($this->options)
            ->unselect($this->unselect)
            ->run();
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

    public function unselect(?string $value): self
    {
        $this->unselect = $value;

        return $this;
    }
}
