<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;

final class TextInput extends Widget
{
    /**
     * Generates a text input tag for the given form attribute.
     *
     * @throws InvalidConfigException
     *
     * @return string the generated input tag.
     */
    public function run(): string
    {
        return Input::widget()
            ->type('text')
            ->data($this->data)
            ->attribute($this->attribute)
            ->options($this->options)
            ->run();
    }
}
