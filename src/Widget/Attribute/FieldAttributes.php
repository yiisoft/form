<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Attribute;

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Form\Helper\HtmlFormErrors;
use Yiisoft\Html\Html;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\MatchRegularExpression;
use Yiisoft\Validator\Rule\Number;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\Url;

trait FieldAttributes
{
    private bool $ariaDescribedBy = false;
    private string $containerClass = '';
    /** @psalm-var array<string, string> */
    private array $containersClass = [];
    private string $errorClass = '';
    /** @psalm-var array<string, string> */
    private array $errorsClass = [];
    private string $errorMessage = '';
    private string $hintClass = '';
    /** @psalm-var array<string, string> */
    private array $hintsClass = [];
    private string $id = '';
    private string $inputClass = '';
    private array $inputsClass = [];
    private string $labelClass = '';
    /** @psalm-var array<string, string> */
    private array $labelsClass = [];
    private string $invalidClass = '';
    /** @psalm-var array<string, string> */
    private array $invalidsClass = [];
    private string $validClass = '';
    /** @psalm-var array<string, string> */
    private array $validsClass = [];
    private array $parts = [];
    private string $template = "{label}\n{input}\n{hint}\n{error}";
    /** @psalm-var array<string, string> */
    private array $templates = [];
    private string $type = '';
    private string $validationStateOn = 'input';
    private ?FormModelInterface $formModel = null;

    /**
     * Set container class each for field type.
     *
     * @param array $containerClass the container class to be used to layout the field.
     *
     * ```php
     * [Field::TYPE_TEXT => 'test-class-1', Field::TYPE_SUBMIT_BUTTON => 'test-class-2']
     *
     * @return static
     *
     * @psalm-param array<string, string> $containerClass
     */
    public function addContainerClass(array $containerClass): self
    {
        $new = clone $this;
        $new->containersClass = $containerClass;
        return $new;
    }

    /**
     * Set error class each for field type.
     *
     * @param array $errorClass the error class to be used to layout the field.
     *
     * ```php
     * [Field::TYPE_TEXT => 'test-class-1', Field::TYPE_SUBMIT_BUTTON => 'test-class-2']
     *
     * @return static
     *
     * @psalm-param array<string, string> $errorClass
     */
    public function addErrorClass(array $errorClass): self
    {
        $new = clone $this;
        $new->errorsClass = $errorClass;
        return $new;
    }

    /**
     * Set hint class each for field type.
     *
     * @param array $hintClass the hint class to be used to layout the field.
     *
     * ```php
     * [Field::TYPE_TEXT => 'test-class-1', Field::TYPE_SUBMIT_BUTTON => 'test-class-2']
     *
     * @return static
     *
     * @psalm-param array<string, string> $hintClass
     */
    public function addHintClass(array $hintClass): self
    {
        $new = clone $this;
        $new->hintsClass = $hintClass;
        return $new;
    }

    /**
     * Set input class each for field type.
     *
     * @param array $inputClass the input class to be used to layout the field.
     *
     * ```php
     * [Field::TYPE_TEXT => 'test-class-1', Field::TYPE_SUBMIT_BUTTON => 'test-class-2']
     *
     * @return static
     *
     * @psalm-param array<string, string> $inputClass
     */
    public function addInputClass(array $inputClass): self
    {
        $new = clone $this;
        $new->inputsClass = $inputClass;
        return $new;
    }

    /**
     * Set invalid class each for field type.
     *
     * @param array $invalidClass the input class to be used to layout the field.
     *
     * ```php
     * [Field::TYPE_TEXT => 'test-class-1', Field::TYPE_SUBMIT_BUTTON => 'test-class-2']
     *
     * @return static
     *
     * @psalm-param array<string, string> $invalidClass
     */
    public function addInvalidClass(array $invalidClass): self
    {
        $new = clone $this;
        $new->invalidsClass = $invalidClass;
        return $new;
    }

    /**
     * Set label class each for field type.
     *
     * @param array $labelClass the input class to be used to layout the field.
     *
     * ```php
     * [Field::TYPE_TEXT => 'test-class-1', Field::TYPE_SUBMIT_BUTTON => 'test-class-2']
     *
     * @return static
     *
     * @psalm-param array<string, string> $labelClass
     */
    public function addLabelClass(array $labelClass): self
    {
        $new = clone $this;
        $new->labelsClass = $labelClass;
        return $new;
    }

    /**
     * Set layout template for render a field with label, input, hint and error.
     *
     * @param array $template the template to be used to layout the field.
     *
     * ```php
     * [Field::TYPE_TEXT => '{input}', Field::TYPE_SUBMIT_BUTTON => '<div>{input}</div>']
     *
     * @return static
     *
     * @psalm-param array<string, string> $template
     */
    public function addTemplate(array $template): self
    {
        $new = clone $this;
        $new->templates = $template;
        return $new;
    }

    /**
     * Set invalid class each for field type.
     *
     * @param array $validsClass the input class to be used to layout the field.
     *
     * ```php
     * [Field::TYPE_TEXT => 'test-class-1', Field::TYPE_SUBMIT_BUTTON => 'test-class-2']
     *
     * @return static
     *
     * @psalm-param array<string, string> $validsClass
     */
    public function addValidClass(array $validsClass): self
    {
        $new = clone $this;
        $new->validsClass = $validsClass;
        return $new;
    }

    /**
     * Set aria-describedby attribute.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/WCAG20-TECHS/ARIA1.html
     */
    public function ariaDescribedBy(): self
    {
        $new = clone $this;
        $new->ariaDescribedBy = true;
        return $new;
    }

    /**
     * Set container css class.
     *
     * @return static
     */
    public function containerClass(string $value): self
    {
        $new = clone $this;
        $new->containerClass = $value;
        return $new;
    }

    /**
     * Set error css class.
     *
     * @return static
     */
    public function errorClass(string $value): self
    {
        $new = clone $this;
        $new->errorClass = $value;
        return $new;
    }

    /**
     * Set hint css class.
     *
     * @return static
     */
    public function hintClass(string $value): self
    {
        $new = clone $this;
        $new->hintClass = $value;
        return $new;
    }

    /**
     * Set input css class.
     *
     * @return static
     */
    public function inputClass(string $value): self
    {
        $new = clone $this;
        $new->inputClass = $value;
        return $new;
    }

    /**
     * Set invalid css class.
     *
     * @return static
     */
    public function invalidClass(string $value): self
    {
        $new = clone $this;
        $new->invalidClass = $value;
        return $new;
    }

    /**
     * Set the label css class.
     *
     * @return static
     */
    public function labelClass(string $value): self
    {
        $new = clone $this;
        $new->labelClass = $value;
        return $new;
    }

    /**
     * Set layout template for render a field.
     *
     * @param string $value
     *
     * @return static
     */
    public function template(string $value): self
    {
        $new = clone $this;
        $new->template = $value;
        return $new;
    }

    /**
     * Set the value valid css class.
     *
     * @param string $value is the valid css class.
     *
     * @return static
     */
    public function validClass(string $value): self
    {
        $new = clone $this;
        $new->validClass = $value;
        return $new;
    }

    private function getSchemePattern(string $scheme): string
    {
        $result = '';
        for ($i = 0, $length = mb_strlen($scheme); $i < $length; $i++) {
            $result .= '[' . mb_strtolower($scheme[$i]) . mb_strtoupper($scheme[$i]) . ']';
        }
        return $result;
    }

    private function setInputAttributes(string $type, array $attributes): array
    {
        $formModel = $this->getFormModel();
        $placeHolder = '';

        // set aria-describedby attribute.
        if ($this->ariaDescribedBy === true) {
            $attributes['aria-describedby'] = $this->getId();
        }

        // set input class attribute.
        /** @var string */
        $inputClass = $this->inputsClass[$type] ?? $this->inputClass;

        if ($inputClass !== '') {
            Html::addCssClass($attributes, $inputClass);
        }

        // set placeholder attribute.
        if (!in_array($type, self::NO_PLACEHOLDER_TYPES, true)) {
            $placeHolder = $this->getFormModel()->getAttributePlaceholder($this->getAttribute());
        }

        if (!isset($attributes['placeholder']) && $placeHolder !== '') {
            $attributes['placeholder'] = $placeHolder;
        }

        // set input class valid and invalid.
        $attributes = $this->setValidAndInvalidClass($formModel, $type, $attributes);

        return $this->setValidatorAttributeHtml($formModel, $type, $attributes);
    }

    private function setValidAndInvalidClass(FormModelInterface $formModel, string $type, array $attributes): array
    {
        $attributeName = HtmlForm::getAttributeName($formModel, $this->getAttribute());

        $invalidClass = $this->invalidsClass[$type] ?? $this->invalidClass;
        $validClass = $this->validsClass[$type] ?? $this->validClass;

        if ($invalidClass !== '' && HtmlFormErrors::hasErrors($formModel, $attributeName)) {
            Html::addCssClass($attributes, $invalidClass);
        } elseif ($validClass !== '' && $formModel->isValidated()) {
            Html::addCssClass($attributes, $validClass);
        }

        return $attributes;
    }

    private function setValidatorAttributeHtml(FormModelInterface $formModel, string $type, array $attributes): array
    {
        /** @var array */
        $rules = $formModel->getRules()[$this->getAttribute()] ?? [];

        /** @var object $rule */
        foreach ($rules as $rule) {
            if ($rule instanceof Required) {
                $attributes['required'] = true;
            }

            if ($rule instanceof HasLength && in_array($type, self::HAS_LENGTH_TYPES, true)) {
                /** @var string */
                $attributes['maxlength'] = $rule->getOptions()['max'];
                /** @var string */
                $attributes['minlength'] = $rule->getOptions()['min'];
            }

            if ($rule instanceof MatchRegularExpression && in_array($type, self::MATCH_REGULAR_EXPRESSION_TYPES, true)) {
                /** @var string */
                $pattern = $rule->getOptions()['pattern'];
                $attributes['pattern'] = Html::normalizeRegexpPattern($pattern);
            }

            if ($rule instanceof Number && in_array($type, self::NUMBER_TYPES, true)) {
                /** @var string */
                $attributes['max'] = $rule->getOptions()['max'];
                /** @var string */
                $attributes['min'] = $rule->getOptions()['min'];
            }

            if ($rule instanceof Url && $type === self::TYPE_URL) {
                /** @var array<array-key, string> */
                $validSchemes = $rule->getOptions()['validSchemes'];

                $schemes = [];
                foreach ($validSchemes as $scheme) {
                    $schemes[] = $this->getSchemePattern($scheme);
                }

                /** @var array<array-key, float|int|string>|string */
                $pattern = $rule->getOptions()['pattern'];
                $normalizePattern = str_replace('{schemes}', '(' . implode('|', $schemes) . ')', $pattern);
                $attributes['pattern'] = Html::normalizeRegexpPattern($normalizePattern);
            }
        }

        return $attributes;
    }
}
