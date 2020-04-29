<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Widget\Widget;

final class TextInput extends Widget
{
    use Options\Common;
    use Options\Input;

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
            ->config($this->data, $this->attribute, $this->options)
            ->run();
    }
}
