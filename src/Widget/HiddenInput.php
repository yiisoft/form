<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Widget\Widget;

final class HiddenInput extends Widget
{
    use Collection\Options;

    /**
     * Generates a hidden input tag for the given form attribute.
     *
     * @throws InvalidConfigException
     *
     * @return string the generated input tag.
     */
    public function run(): string
    {
        return Input::widget()
            ->type('hidden')
            ->config($this->data, $this->attribute, $this->options)
            ->run();
    }
}
