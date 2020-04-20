<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Form\FormInterface;

trait WidgetInputOptions
{
    protected bool $autofocus = false;
    protected bool $ariaAttribute = true;
    protected bool $disabled = false;
    protected array $inputOptions = [];
    protected int $maxlength = 0;
    protected ?string $placeHolder = null;
    protected bool $required = true;
    protected int $size = 0;
    protected ?string $tabindex = null;

    protected function configInputOptions(array $options = []): void
    {
        $this->adjustLabelFor($options);
        $this->addAriaAttribute($options);
        $this->addAutofocus($options);
        $this->addDisabled($options);
        $this->addMaxLength($options);
        $this->addPlaceHoder($options);
        $this->addRequired($options);
        $this->addTabIndex($options);
        $this->addSize($options);
    }

    public function autofocus(bool $value): self
    {
        $this->autofocus = $value;

        return $this;
    }

    public function ariaAttribute(bool $value): self
    {
        $this->ariaAttribute = $value;

        return $this;
    }

    /**
     * Adds aria attributes to the input options.
     *
     * @param array $options array input options
     */
    protected function addAriaAttribute(array $options = []): void
    {
        if ($this->ariaAttribute && ($this->form instanceof FormInterface)) {
            if (!isset($options['aria-required']) && $this->form->isAttributeRequired($this->attribute)) {
                $this->inputOptions['aria-required'] = 'true';
            }

            if (!isset($options['aria-invalid'])) {
                if ($this->form->hasErrors($this->attribute)) {
                    $this->inputOptions['aria-invalid'] = 'true';
                }
            }
        }
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

    private function addPlaceHoder(array $options = []): void
    {
        if (!isset($options['placeholder']) && $this->placeHolder !== null) {
            $this->inputOptions['placeholder'] = $this->placeHolder;
        }
    }

    private function addRequired(array $options = []): void
    {
        if (!isset($options['required'])) {
            $this->inputOptions['required'] = $this->required;
        }
    }

    private function addTabIndex(): void
    {
        if (!isset($options['tabindex']) && $this->tabindex) {
            $this->inputOptions['tabindex'] = $this->tabindex;
        }
    }

    private function addSize(): void
    {
        if (!isset($options['size']) && $this->size > 0) {
            $this->inputOptions['size'] = $this->size;
        }
    }

    public function disabled(bool $value): self
    {
        $this->disabled = $value;

        return $this;
    }

    /**
     * @param array the default options for the input tags. The parameter passed to individual input methods
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
        $this->inputOptions = $value;

        return $this;
    }

    public function maxlength(int $value): self
    {
        $this->maxlength = $value;

        return $this;
    }

    public function placeHolder(string $value): self
    {
        $this->placeHolder = $value;

        return $this;
    }

    public function required(bool $value): self
    {
        $this->required = $value;

        return $this;
    }

    public function size(int $value): self
    {
        $this->size = $value;

        return $this;
    }

    public function tabindex(string $value): self
    {
        $this->tabindex = $value;

        return $this;
    }
}
