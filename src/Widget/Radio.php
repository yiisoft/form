<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;

final class Radio extends Widget
{
    private bool $label = true;
    private bool $uncheck = false;

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
            ->label($this->label)
            ->uncheck($this->uncheck)
            ->options($this->options)
            ->run();
    }

    public function label(bool $value): self
    {
        $this->label = $value;

        return $this;
    }

    public function uncheck(bool $value): self
    {
        $this->uncheck = $value;

        return $this;
    }
}
