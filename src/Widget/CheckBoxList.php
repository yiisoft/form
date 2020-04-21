<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Widget\Widget;

final class CheckBoxList extends Widget
{
    use Collection\Options;
    use Collection\InputOptions;
    use Collection\ListOptions;

    /**
     * Generates a list of checkboxes.
     *
     * A checkbox list allows multiple selection, like {@see ListBox}.
     *
     * @throws InvalidConfigException
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
}
