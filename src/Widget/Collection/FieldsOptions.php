<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Collection;

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Html\Html;

trait FieldsOptions
{
    private ?FormModelInterface $data = null;
    private string $attribute;
    private array $options = [];
    private array $inputOptions = [];
    private array $labelOptions = [];
    private bool $ariaAttribute = true;
    private string $errorCss = 'has-error';
    private string $errorSummaryCss = 'error-summary';
    private string $inputCss = 'form-control';
    private string $requiredCss = 'required';
    private string $successCss = 'has-success';
    private string $template = "{label}\n{input}\n{hint}\n{error}";
    private string $validatingCss = 'validating';
    private string $validationStateOn = 'input';
    private ?string $inputId = null;
    private array $parts = [];
    private bool $skipForInLabel = false;

    public function config(FormModelInterface $data, string $attribute, array $options = []): self
    {
        $new = clone $this;
        $new->data = $data;
        $new->attribute = $attribute;
        $new->options = $options;
        return $new;
    }

    public function ariaAttribute(bool $value): self
    {
        $new = clone $this;
        $new->ariaAttribute = $value;
        return $new;
    }

    public function errorCss(string $value): self
    {
        $new = clone $this;
        $new->errorCss = $value;
        return $new;
    }

    public function errorSummaryCss(string $value): self
    {
        $new = clone $this;
        $new->errorSummaryCss = $value;
        return $new;
    }

    public function inputCss(string $value): self
    {
        $new = clone $this;
        $new->inputCss = $value;
        return $new;
    }

    public function requiredCss(string $value): self
    {
        $new = clone $this;
        $new->requiredCss = $value;
        return $new;
    }

    public function successCss(string $value): self
    {
        $new = clone $this;
        $new->successCss = $value;
        return $new;
    }

    public function template(string $value): self
    {
        $new = clone $this;
        $new->template = $value;
        return $new;
    }

    public function validatingCss(string $value): self
    {
        $new = clone $this;
        $new->validatingCss = $value;
        return $new;
    }

    public function validationStateOn(string $value): self
    {
        $new = clone $this;
        $new->validationStateOn = $value;
        return $new;
    }

    private function setAriaAttributes(array $options = []): void
    {
        if ($this->ariaAttribute && ($this->data instanceof FormModelInterface)) {
            if (!isset($options['aria-required']) && $this->data->isAttributeRequired($this->attribute)) {
                $this->inputOptions['aria-required'] = 'true';
            }

            if (!isset($options['aria-invalid']) && $this->data->hasErrors($this->attribute)) {
                $this->inputOptions['aria-invalid'] = 'true';
            }
        }
    }

    private function addErrorCssClassToContainer(): void
    {
        if ($this->validationStateOn === 'container') {
            Html::addCssClass($this->options, $this->errorCss);
        }
    }

    private function addErrorCssClassToInput(): void
    {
        if ($this->validationStateOn === 'input') {
            $attributeName = Html::getAttributeName($this->attribute);

            if ($this->data->hasErrors($attributeName)) {
                Html::addCssClass($this->inputOptions, $this->errorCss);
            }
        }
    }

    private function addErrorCssClass(array $options = []): void
    {
        $class = $options['class'] ?? self::ERROR_CSS['class'];

        if ($class !== self::ERROR_CSS['class']) {
            $class = self::ERROR_CSS['class'] . ' ' . $options['class'];
        }

        Html::addCssClass($this->inputOptions, $class);
    }

    private function addHintCssClass(array $options = []): void
    {
        $class = $options['class'] ?? self::HINT_CSS['class'];

        if ($class !== self::HINT_CSS['class']) {
            $class = self::HINT_CSS['class'] . ' ' . $options['class'];
        }

        Html::addCssClass($this->inputOptions, $class);
    }

    private function addInputCssClass(array $options = []): void
    {
        $class = $options['class'] ?? $this->inputCss;

        if ($class !== $this->inputCss) {
            $class = $this->inputCss . ' ' . $options['class'];
        }

        Html::addCssClass($this->inputOptions, $class);
    }

    private function addLabelCssClass(array $options = []): void
    {
        $class = $options['class'] ?? self::LABEL_CSS['class'];

        if ($class !== self::LABEL_CSS['class']) {
            $class = self::LABEL_CSS['class'] . ' ' . $options['class'];
        }

        Html::addCssClass($this->inputOptions, $class);
    }

    private function setInputRole(array $options = []): void
    {
        $this->inputOptions['role'] = $options['role'] ?? 'radiogroup';
    }

    private function skipForInLabel(): void
    {
        if ($this->skipForInLabel) {
            $this->inputOptions['for'] = null;
        }
    }

    private function setForInLabel(array $options = []): void
    {
        if (isset($options['id'])) {
            $this->inputId = $options['id'];

            if (!isset($new->labelOptions['for'])) {
                $this->labelOptions['for'] = $options['id'];
            }
        }
    }
}
