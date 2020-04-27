<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Collection;

use Yiisoft\Form\FormInterface;
use Yiisoft\Html\Html;

trait FieldsOptions
{
    private ?FormInterface $data = null;
    private string $attribute;
    private array $options = [];
    private array $inputOptions = [];
    private array $labelOptions = [];
    private bool $ariaAttribute = true;
    private string $errorCss = 'has-error';
    private string $errorSummaryCss = 'error-summary';
    private string $inputCss = 'form-control';
    private string $requiredCss = 'required';
    private string $succesCss = 'has-success';
    private string $template = "{label}\n{input}\n{hint}\n{error}";
    private string $validatingCss = 'validating';
    private string $validationStateOn = 'input';
    private ?string $inputId = null;
    private array $parts = [];
    private bool $skipLabelFor = false;

    public function config(FormInterface $data, string $attribute, array $options = []): self
    {
        $new = clone $this;
        $new->data = $data;
        $new->attribute = $attribute;
        $new->options = $options;
        return $new;
    }

    public function ariaAttribute(bool $value): self
    {
        $this->ariaAttribute = $value;
        return $this;
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

    public function succesCss(string $value): self
    {
        $new = clone $this;
        $new->succesCss = $value;
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

    private function addAriaAttributes(self $new, array $options = []): self
    {
        if ($new->ariaAttribute && ($new->data instanceof FormInterface)) {
            if (!isset($options['aria-required']) && $new->data->isAttributeRequired($new->attribute)) {
                $new->inputOptions['aria-required'] = 'true';
            }

            if (!isset($options['aria-invalid']) && $new->data->hasErrors($new->attribute)) {
                $new->inputOptions['aria-invalid'] = 'true';
            }
        }

        return $new;
    }

    private function addErrorCssContainer(self $new): self
    {
        if ($new->validationStateOn === 'container') {
            Html::addCssClass($new->options, $this->errorCss);
        }

        return $new;
    }

    private function addErrorCssInput(self $new): self
    {
        if ($new->validationStateOn === 'input') {
            $attributeName = Html::getAttributeName($new->attribute);

            if ($new->data->hasErrors($attributeName)) {
                Html::addCssClass($new->inputOptions, $new->errorCss);
            }
        }

        return $new;
    }

    private function addErrorCss(self $new, array $options = []): self
    {
        if (!isset($options['class'])) {
            Html::addCssClass($new->inputOptions, self::ERROR_CSS);
        } elseif ($options['class'] !== 'help-block') {
            Html::addCssClass($new->inputOptions, self::ERROR_CSS . ' ' . $options['class']);
        }

        return $new;
    }

    private function addHintCss(self $new, array $options = []): self
    {
        if (!isset($options['class'])) {
            Html::addCssClass($new->inputOptions, self::HINT_CSS);
        } elseif ($options['class'] !== 'hint-block') {
            Html::addCssClass($new->inputOptions, self::HINT_CSS . ' ' . $options['class']);
        }

        return $new;
    }

    private function addInputCss(self $new, array $options = []): self
    {
        if (!isset($options['class'])) {
            Html::addCssClass($new->inputOptions, $this->inputCss);
        } elseif ($options['class'] !== 'form-control') {
            Html::addCssClass($new->inputOptions, $this->inputCss . ' ' . $options['class']);
        }

        return $new;
    }

    private function addLabelCss(self $new, array $options = []): self
    {
        if (!isset($options['class'])) {
            Html::addCssClass($new->inputOptions, self::LABEL_CSS);
        } elseif ($options['class'] !== 'control-label') {
            Html::addCssClass($new->inputOptions, self::LABEL_CSS . ' ' . $options['class']);
        }

        return $new;
    }

    private function addSkipLabelFor(self $new): self
    {
        if ($new->skipLabelFor) {
            $new->inputOptions['for'] = null;
        }

        return $new;
    }

    private function adjustLabelFor(self $new, array $options = []): self
    {
        if (isset($options['id'])) {
            $new->inputId = $options['id'];

            if (!isset($new->labelOptions['for'])) {
                $new->labelOptions['for'] = $options['id'];
            }
        }

        return $new;
    }
}
