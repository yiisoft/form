<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;

final class ListBox extends Widget
{
    private bool $multiple = false;
    private array $items = [];
    private ?string $unselect = null;

    /**
     * Generates a list box.
     *
     * The selection of the list box is taken from the value of the model attribute.
     *
     * @throws InvalidConfigException
     *
     * @return string the generated list box tag.
     */
    public function run(): string
    {
        $this->options['size'] = $this->size;

        if ($this->size === 0) {
            $this->options['size'] = 4;
        }

        return ListInput::Widget()
            ->type('listBox')
            ->form($this->form)
            ->attribute($this->attribute)
            ->items($this->items)
            ->multiple($this->multiple)
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
