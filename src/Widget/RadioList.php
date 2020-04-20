<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

final class RadioList extends Widget
{
    private array $items = [];
    private ?string $unselect = '';

    /**
     * Generates a list of radio buttons.
     *
     * A radio button list is like a checkbox list, except that it only allows single selection.
     *
     * @return string the generated radio button list
     */
    public function run(): string
    {
        return ListInput::widget()
            ->type('radioList')
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
