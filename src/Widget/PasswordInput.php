<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Widget\Widget;

final class PasswordInput extends Widget
{
    use Collection\Options;
    use Collection\InputOptions;

    /**
     * Generates a password input tag for the given form attribute.
     *
     * @throws InvalidConfigException
     *
     * @return string the generated input tag,
     */
    public function run(): string
    {
        return Input::widget()
            ->type('password')
            ->config($this->data, $this->attribute, $this->options)
            ->run();
    }
}
