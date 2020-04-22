<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Collection;

use Yiisoft\Form\FormInterface;

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
}
