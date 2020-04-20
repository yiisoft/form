<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

final class DatePicker extends Widget
{
    /**
     * Generates a datepicker tag together with a label for the given form attribute.
     *
     * @return string the generated checkbox tag.
     */
    public function run(): string
    {
        return Input::widget()
            ->type('date')
            ->form($this->form)
            ->attribute($this->attribute)
            ->options($this->options)
            ->run();
    }
}
