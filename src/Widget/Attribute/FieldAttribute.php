<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Attribute;

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Html\Html;
use Yiisoft\Validator\Rule\Number;
use Yiisoft\Validator\Rule\Required;

trait FieldAttribute
{
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
     * Set form interface, attribute name and attributes, and attributes for the widget.
     *
     * @param FormModelInterface $formModel Form.
     * @param string $attribute Form model property this widget is rendered for.
     * @param array $attributes The HTML attributes for the widget container tag.
     *
     * @return static
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    final public function config(FormModelInterface $formModel, string $attribute, array $attributes = []): self
    {
        $new = clone $this;
        $new->formModel = $formModel;
        $new->attribute = $attribute;
        $new->attributes = $attributes;
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
     * Set error description message.
     *
     * @return static
     */
    public function errorMessage(string $value): self
    {
        $new = clone $this;
        $new->errorMessage = $value;
        return $new;
    }

    /**
     * Return the imput id.
     *
     * @return string
     */
    protected function getId(): string
    {
        $new = clone $this;

        /** @var string */
        $id = $new->attributes['id'] ?? $new->id;

        return $id === '' ? HtmlForm::getInputId($new->formModel, $new->attribute) : $id;
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
     * @param string $template
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

    private function addValidatorAttributeHtml(
        FormModelInterface $formModel,
        string $attribute,
        array $attributes
    ): array {
        $rules = $formModel->getRules()[$attribute] ?? [];

        foreach ($rules as $rule) {
            if ($rule instanceof Number) {
                $attributes['max'] = $rule->getOptions()['max'];
                $attributes['min'] = $rule->getOptions()['min'];
            }
            if ($rule instanceof Required) {
                $attributes['required'] = true;
            }
        }

        return $attributes;
    }

    private function setInputAttributes(array $attributes): array
    {
        $new = clone $this;

        $attributes = $new->addValidatorAttributeHtml($new->formModel, $new->attribute, $attributes);

        if ($new->ariaDescribedBy === true) {
            $attributes['aria-describedby'] = $new->getId();
        }

        if ($new->inputClass !== '') {
            Html::addCssClass($attributes, $new->inputClass);
        }

        return $attributes;
    }
}
