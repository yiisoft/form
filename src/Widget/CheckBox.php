<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

final class CheckBox extends Widget
{
    private bool $label = true;
    private bool $uncheck = false;

    /**
     * Generates a checkbox tag together with a label for the given form attribute.
     *
     * This method will generate the "checked" tag attribute according to the form attribute value.
     *
     * @return string the generated checkbox tag.
     */
    public function run(): string
    {
        return (new BooleanInput())
            ->type('checkbox')
            ->id($this->id)
            ->data($this->data)
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
