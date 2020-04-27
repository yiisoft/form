<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Widget\Widget;

final class DropDownList extends Widget
{
    use Collection\Options;
    use Collection\InputOptions;

    private array $items = [];

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
        if (!$this->options['multiple']) {
            return ListInput::widget()
                ->type('dropDownList')
                ->config($this->data, $this->attribute, $this->options)
                ->items($this->items)
                ->run();
        }

        return ListBox::widget()
            ->type('dropDownList')
            ->config($this->data, $this->attribute, $this->options)
            ->items($this->items)
            ->run();
    }

    public function items(array $value): self
    {
        $new = clone $this;
        $new->items = $value;
        return $new;
    }
}
