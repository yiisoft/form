<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Widget\Widget;

final class CheckBox extends Widget
{
    private ?string $id = null;
    private FormModelInterface $data;
    private string $attribute;
    private array $options = [];
    private string $charset = 'UTF-8';
    private bool $noForm = false;
    private bool $noLabel = false;
    private bool $uncheck = true;

    /**
     * Generates a checkbox tag together with a label for the given form attribute.
     *
     * This method will generate the "checked" tag attribute according to the form attribute value.
     *
     * @return string the generated checkbox tag.
     */
    public function run(): string
    {
        return BooleanInput::widget()
            ->type('checkbox')
            ->id($this->id)
            ->config($this->data, $this->attribute, $this->options)
            ->noForm($this->noForm)
            ->noLabel($this->noLabel)
            ->uncheck($this->uncheck)
            ->run();
    }

    public function config(FormModelInterface $data, string $attribute, array $options = []): self
    {
        $new = clone $this;
        $new->data = $data;
        $new->attribute = $attribute;
        $new->options = $options;
        return $new;
    }

    public function autofocus(bool $value = true): self
    {
        $new = clone $this;
        $new->options['autofocus'] = $value;
        return $new;
    }

    public function charset(string $value): self
    {
        $new = clone $this;
        $new->charset = $value;
        return $new;
    }

    public function disabled(bool $value = true): self
    {
        $new = clone $this;
        $new->options['disabled'] = $value;
        return $new;
    }

    public function form(string $value): self
    {
        $new = clone $this;
        $new->options['form'] = $value;
        return $new;
    }

    public function id(?string $value): self
    {
        $new = clone $this;
        $new->id = $value;
        return $new;
    }

    public function label(string $value): self
    {
        $new = clone $this;
        $new->options['label'] = $value;
        return $new;
    }

    public function labelOptions(array $value = []): self
    {
        $new = clone $this;
        $new->options['labelOptions'] = $value;
        return $new;
    }

    public function noForm(bool $value = true): self
    {
        $new = clone $this;
        $new->noForm = $value;
        return $new;
    }

    public function noLabel(bool $value = true): self
    {
        $new = clone $this;
        $new->noLabel = $value;
        return $new;
    }

    public function uncheck(bool $value = true): self
    {
        $new = clone $this;
        $new->uncheck = $value;
        return $new;
    }
}
