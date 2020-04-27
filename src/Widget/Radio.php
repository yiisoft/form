<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Widget\Widget;

final class Radio extends Widget
{
    use Collection\Options;
    use Collection\InputOptions;

    private bool $label = true;

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
            ->config($this->data, $this->attribute, $this->options)
            ->run();
    }
}
