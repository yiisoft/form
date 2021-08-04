<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Yiisoft\Html\Tag\Input\Checkbox as CheckboxTag;

/**
 * Generates a checkbox tag together with a label for the given form attribute.
 *
 * This method will generate the "checked" tag attribute according to the form attribute value.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.checkbox.html#input.checkbox
 */
final class Checkbox extends Widget
{
    private bool $enclosedByLabel = true;
    private bool $forceUncheckedValue = true;

    /**
     * Focus on the control (put cursor into it) when the page loads.
     * Only one form element could be in focus at the same time.
     *
     * @param bool $value
     *
     * @return static
     */
    public function autofocus(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['autofocus'] = $value;
        return $new;
    }

    /**
     * Set whether the element is disabled or not.
     *
     * If this attribute is set to `true`, the element is disabled. Disabled elements are usually drawn with grayed-out
     * text.
     * If the element is disabled, it does not respond to user actions, it cannot be focused, and the command event
     * will not fire. In the case of form elements, it will not be submitted. Do not set the attribute to true, as
     * this will suggest you can set it to false to enable the element again, which is not the case.
     *
     * @param bool $value
     *
     * @return static
     */
    public function disabled(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['disabled'] = $value;
        return $new;
    }

    /**
     * If the widget should be enclosed by label.
     *
     * @param bool $value If the widget should be en closed by label.
     *
     * @return static
     */
    public function enclosedByLabel(bool $value = true): self
    {
        $new = clone $this;
        $new->enclosedByLabel = $value;
        return $new;
    }

    /**
     * Whether to generate hidden input for uncheck state of the checkbox.
     *
     * When this attribute is present, a hidden input will be generated so that if the checkbox is not checked and
     * is submitted, the value of this attribute will still be submitted to the server via the hidden input.
     *
     * @param bool $value The value associated with the uncheck state of the checkbox.
     *
     * @return static
     */
    public function forceUncheckedValue(bool $value = true): self
    {
        $new = clone $this;
        $new->forceUncheckedValue = $value;
        return $new;
    }

    /**
     * Specifies the form element the tag input element belongs to. The value of this attribute must be the id
     * attribute of a {@see Form} element in the same document.
     *
     * @param string $value
     *
     * @return static
     */
    public function form(string $value): self
    {
        $new = clone $this;
        $new->attributes['form'] = $value;
        return $new;
    }

    /**
     * Label displayed next to the checkbox.
     *
     * It will NOT be HTML-encoded, therefore you can pass in HTML code such as an image tag. If this is is coming from
     * end users, you should {@see encode()} it to prevent XSS attacks.
     *
     * When this option is specified, the checkbox will be enclosed by a label tag.
     *
     * @param string $value
     *
     * @return static
     */
    public function label(string $value): self
    {
        $new = clone $this;
        $new->attributes['label'] = $value;
        return $new;
    }

    /**
     * HTML attributes for the label tag.
     *
     * Do not set this option unless you set the "label" attributes.
     *
     * @param array $value
     *
     * @return static
     */
    public function labelAttributes(array $value = []): self
    {
        $new = clone $this;
        $new->attributes['labelAttributes'] = $value;
        return $new;
    }

    /**
     * If it is required to fill in a value in order to submit the form.
     *
     * @param bool $value
     *
     * @return static
     */
    public function required(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['required'] = $value;
        return $new;
    }

    /**
     * @return string the generated checkbox tag.
     */
    protected function run(): string
    {
        $new = clone $this;

        $checkbox = CheckboxTag::tag();

        if ($new->enclosedByLabel === true) {
            /** @var string */
            $label = $new->attributes['label'] ?? $new->getLabel();

            /** @var array */
            $labelAttributes = $new->attributes['labelAttributes'] ?? [];

            unset($new->attributes['label'], $new->attributes['labelAttributes']);

            $checkbox = $checkbox->label($label, $labelAttributes);
        }

        if ($new->forceUncheckedValue) {
            $checkbox = $checkbox->uncheckValue('0');
        }

        $value = $new->getValue();

        if (is_iterable($value) || is_object($value)) {
            throw new InvalidArgumentException('The value must be a bool|float|int|string|Stringable|null.');
        }

        if (!array_key_exists('value', $new->attributes)) {
            $new->attributes['value'] = '1';
        }

        return $checkbox
            ->attributes($new->attributes)
            ->checked((bool) $value)
            ->id($new->getId())
            ->name($new->getInputName())
            ->render();
    }
}
