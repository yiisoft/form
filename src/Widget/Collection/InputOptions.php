<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Collection;

trait InputOptions
{
    private bool $autofocus = false;
    private bool $ariaAttribute = true;
    private bool $disabled = false;
    private ?string $inputId = null;
    private array $inputOptions = [];
    private array $labelOptions = ['class' => 'control-label'];
    private int $maxlength = 0;
    private ?string $placeholder = null;
    private bool $required = true;
    private int $size = 0;
    private ?string $tabindex = null;

    protected function configInputOptions(array $options = []): void
    {
        $this->adjustLabelFor($options);
        $this->addAutofocus($options);
        $this->addDisabled($options);
        $this->addMaxLength($options);
        $this->addPlaceholder($options);
        $this->addRequired($options);
        $this->addTabIndex($options);
        $this->addSize($options);
    }

    public function autofocus(bool $value): self
    {
        $immutable = clone $this;
        $immutable->autofocus = $value;
        return $immutable;
    }

    public function ariaAttribute(bool $value): self
    {
        $immutable = clone $this;
        $immutable->ariaAttribute = $value;
        return $immutable;
    }

    public function disabled(bool $value): self
    {
        $immutable = clone $this;
        $immutable->disabled = $value;
        return $immutable;
    }

    /**
     * @param array $value the default options for the input tags. The parameter passed to individual input methods
     * (e.g. {@see textInput()} will be merged with this property when rendering the input tag.
     *
     * If you set a custom `id` for the input element, you may need to adjust the {@see $selectors} accordingly.
     *
     * @return self
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function inputOptions(array $value): self
    {
        $immutable = clone $this;
        $immutable->inputOptions = $value;
        return $immutable;
    }

    public function maxlength(int $value): self
    {
        $immutable = clone $this;
        $immutable->maxlength = $value;
        return $immutable;
    }

    public function placeholder(string $value): self
    {
        $immutable = clone $this;
        $immutable->placeholder = $value;
        return $immutable;
    }

    public function required(bool $value): self
    {
        $immutable = clone $this;
        $immutable->required = $value;
        return $immutable;
    }

    public function size(int $value): self
    {
        $immutable = clone $this;
        $immutable->size = $value;
        return $immutable;
    }

    public function tabindex(string $value): self
    {
        $immutable = clone $this;
        $immutable->tabindex = $value;
        return $immutable;
    }

    private function addAutofocus(array $options = []): void
    {
        if (!isset($options['autofocus']) && $this->autofocus) {
            $this->inputOptions['autofocus'] = $this->autofocus;
        }
    }

    /**
     * Adjusts the `for` attribute for the label based on the input options.
     *
     * @param array $options the input options.
     */
    private function adjustLabelFor(array $options = []): void
    {
        if (!isset($options['id'])) {
            return;
        }

        $this->inputId = $options['id'];

        if (!isset($this->labelOptions['for'])) {
            $this->labelOptions['for'] = $options['id'];
        }
    }

    private function addDisabled(array $options = []): void
    {
        if (!isset($options['disabled'])) {
            $this->inputOptions['disabled'] = $this->disabled;
        }
    }

    private function addMaxLength(array $options = []): void
    {
        if (!isset($options['maxlength']) && $this->maxlength > 0) {
            $this->inputOptions['maxlength'] = $this->maxlength;
        }
    }

    private function addPlaceholder(array $options = []): void
    {
        if (!isset($options['placeholder']) && $this->placeholder !== null) {
            $this->inputOptions['placeholder'] = $this->placeholder;
        }
    }

    private function addRequired(array $options = []): void
    {
        if (!isset($options['required'])) {
            $this->inputOptions['required'] = $this->required;
        }
    }

    private function addTabIndex(array $options = []): void
    {
        if (!isset($options['tabindex']) && $this->tabindex) {
            $this->inputOptions['tabindex'] = $this->tabindex;
        }
    }

    private function addSize(array $options = []): void
    {
        if (!isset($options['size']) && $this->size > 0) {
            $this->inputOptions['size'] = $this->size;
        }
    }
}
