<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Collection;

use Yiisoft\Form\FormInterface;
use Yiisoft\Html\Html;

trait FieldBuilderOptions
{
    private string $errorCss = 'has-error';
    private string $errorSummaryCss = 'error-summary';
    private string $inputCss = 'form-control';
    private array $parts = [];
    private string $requiredCss = 'required';
    private string $succesCss = 'has-success';
    private bool $skipLabelFor = false;
    private string $validatingCss = 'validating';
    private string $validationStateOn = 'input';
    private array $optionsField = [];

    public function errorCss(string $value): self
    {
        $this->errorCss = $value;

        return $this;
    }

    public function errorSummaryCss(string $value): self
    {
        $this->errorSummaryCss = $value;

        return $this;
    }

    public function inputCss(string $value): self
    {
        $this->inputCss = $value;

        return $this;
    }

    /**
     * @param array $value different parts of the field (e.g. input, label). This will be used together with
     * {@see template} to generate the final field HTML code. The keys are the token names in {@see template}, while
     * the values are the corresponding HTML code. Valid tokens include `{input}`, `{label}` and `{error}`. Note that
     * you normally don't need to access this property directly as it is maintained by various methods of this class.
     *
     * @return self
     */
    public function parts(array $value): self
    {
        $this->parts = $value;

        return $this;
    }

    public function requiredCss(string $value): self
    {
        $this->requiredCss = $value;

        return $this;
    }

    public function skipLabelFor(bool $value): self
    {
        $this->skipLabelFor = $value;

        return $this;
    }

    public function succesCss(string $value): self
    {
        $this->succesCss = $value;

        return $this;
    }

    public function validatingCss(string $value): self
    {
        $this->validatingCss = $value;

        return $this;
    }

    public function validationStateOn(string $value): self
    {
        $this->validationStateOn = $value;

        return $this;
    }

    private function addLabel(string $value): void
    {
        $this->optionsField['label'] = $value;
    }

    private function addSkipLabelFor(): void
    {
        if ($this->skipLabelFor) {
            $this->optionsField['for'] = null;
        }
    }

    /**
     * Adds aria attributes to the input options.
     *
     * @param array $options array input options
     */
    private function addAriaAttributes(array $options = []): void
    {
        if ($this->ariaAttribute && ($this->data instanceof FormInterface)) {
            if (!isset($options['aria-required']) && $this->data->isAttributeRequired($this->attribute)) {
                $this->optionsField['aria-required'] = 'true';
            }

            if (!isset($options['aria-invalid']) && $this->data->hasErrors($this->attribute)) {
                $this->optionsField['aria-invalid'] = 'true';
            }
        }
    }

    private function addErrorClassIfNeeded(): void
    {
        if ($this->validationStateOn === 'input' || $this->validationStateOn === 'container') {
            $attributeName = Html::getAttributeName($this->attribute);

            if ($this->data->hasErrors($attributeName)) {
                Html::addCssClass($this->optionsField, $this->errorCss);
            }
        }
    }

    private function addInputCssClass(array $options = []): void
    {
        if (!isset($options['class'])) {
            Html::addCssClass($this->optionsField, $this->inputCss);
        } elseif ($options['class'] !== 'form-control') {
            Html::addCssClass($this->optionsField, $this->inputCss . ' ' . $options['class']);
        }
    }
}
