<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Widget\Widget;

final class RadioList extends Widget
{
    use Collection\Options;
    use Collection\InputOptions;

    private array $items = [];

    /**
     * Generates a list of radio buttons.
     *
     * A radio button list is like a checkbox list, except that it only allows single selection.
     *
     * @throws InvalidConfigException
     *
     * @return string the generated radio button list
     */
    public function run(): string
    {
        return ListInput::widget()
            ->type('radioList')
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
