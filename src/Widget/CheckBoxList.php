<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

final class CheckBoxList extends Widget
{
    private array $items = [];
    private ?string $unselect = '';

    /**
     * Generates a list of checkboxes.
     *
     * A checkbox list allows multiple selection, like {@see ListBox}.
     *
     * @return string the generated checkbox list.
     */
    public function run(): string
    {
        return ListInput::widget()
            ->type('checkboxList')
            ->data($this->data)
            ->attribute($this->attribute)
            ->items($this->items)
            ->options($this->options)
            ->unselect($this->unselect)
            ->run();
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
