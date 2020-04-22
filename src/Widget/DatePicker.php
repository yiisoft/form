<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Widget\Widget;

final class DatePicker extends Widget
{
    use Collection\Options;

    /**
     * Generates a datepicker tag together with a label for the given form attribute.
     *
     * @throws InvalidConfigException
     *
     * @return string the generated checkbox tag.
     */
    public function run(): string
    {
        return Input::widget()
            ->type('date')
            ->data($this->data)
            ->attribute($this->attribute)
            ->options($this->options)
            ->run();
    }
}
