<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Attribute;

abstract class InputAttributes extends WidgetAttributes
{
    /**
     * Identifies the element (or elements) that describes the element on which the attribute is set.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Attributes/aria-describedby
     */
    public function ariaDescribedBy(string $value): static
    {
        $new = clone $this;
        $new->attributes['aria-describedby'] = $value;
        return $new;
    }

    /**
     * Defines a string value that labels an interactive element.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Attributes/aria-label
     */
    public function ariaLabel(string $value): static
    {
        $new = clone $this;
        $new->attributes['aria-label'] = $value;
        return $new;
    }

    /**
     * Specifies the form element the tag input element belongs to. The value of this attribute must be the id
     * attribute of a {@see Form} element in the same document.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fae-form
     */
    public function form(string $value): static
    {
        $new = clone $this;
        $new->attributes['form'] = $value;
        return $new;
    }

    /**
     * A Boolean attribute which, if present, means this field cannot be edited by the user.
     * Its value can, however, still be changed by JavaScript code directly setting the HTMLInputElement.value
     * property.
     *
     * @param bool $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#the-readonly-attribute
     */
    public function readonly(bool $value = true): static
    {
        $new = clone $this;
        $new->attributes['readonly'] = $value;
        return $new;
    }

    /**
     * If it is required to fill in a value in order to submit the form.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#the-required-attribute
     */
    public function required(): static
    {
        $new = clone $this;
        $new->attributes['required'] = true;
        return $new;
    }

    /**
     * Set build attributes for the widget.
     *
     * @param array $attributes $value
     *
     * @return array
     */
    protected function build(array $attributes): array
    {
        if (!array_key_exists('id', $attributes)) {
            $attributes['id'] = $this->getInputId();
        }

        if (!array_key_exists('name', $attributes)) {
            $attributes['name'] = $this->getInputName();
        }

        return $attributes;
    }
}
