<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Widget\Widget;

final class DropDownList extends Widget
{
    use Collection\Options;
    use Collection\InputOptions;
    use Collection\ListOptions;

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
                ->data($this->data)
                ->attribute($this->attribute)
                ->items($this->items)
                ->options($this->options)
                ->unselect($this->unselect)
                ->run();
        }

        $this->options['multiple'] = 'true';

        return ListBox::widget()
            ->type('dropDownList')
            ->data($this->data)
            ->attribute($this->attribute)
            ->items($this->items)
            ->options($this->options)
            ->unselect($this->unselect)
            ->run();
    }
}
