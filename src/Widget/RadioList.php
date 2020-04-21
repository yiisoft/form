<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Form\Exception\InvalidArgumentException;
use Yiisoft\Widget\Widget;

final class RadioList extends Widget
{
    use Collection\Options;
    use Collection\InputOptions;
    use Collection\ListOptions;

    /**
     * Generates a list of radio buttons.
     *
     * A radio button list is like a checkbox list, except that it only allows single selection.
     *
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
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
}
