<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;

final class Radio extends Widget
{
    /**
     * Generates a radio button tag together with a label for the given form attribute.
     *
     * @throws InvalidConfigException
     *
     * @return string the generated radio button tag.
     */
    public function run(): string
    {
        return BooleanInput::widget()
            ->type('radio')
            ->form($this->form)
            ->attribute($this->attribute)
            ->options($this->options)
            ->run();
    }
}
