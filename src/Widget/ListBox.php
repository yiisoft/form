<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Widget\Widget;

final class ListBox extends Widget
{
    use Collection\Options;
    use Collection\InputOptions;
    use Collection\ListOptions;

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
        $this->addCustomUnselect();
        $this->addOptionSize();

        return ListInput::Widget()
            ->type('listBox')
            ->data($this->data)
            ->attribute($this->attribute)
            ->items($this->items)
            ->multiple($this->multiple)
            ->options($this->options)
            ->unselect($this->unselect)
            ->run();
    }

    private function addCustomUnselect(): void
    {
        if ($this->type !== 'dropDownList') {
            $this->unselect =  $this->unselect === '' ? null : $this->unselect;
        }
    }

    private function addOptionSize(): void
    {
        $this->options['size'] = $this->size;

        if ($this->size === 0) {
            $this->options['size'] = 4;
        }
    }
}
