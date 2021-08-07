<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Form\Widget\Attribute\CommonAttribute;
use Yiisoft\Html\Tag\Input\Checkbox as CheckboxTag;

/**
 * The input element with a type attribute whose value is "checkbox" represents a state or option that can be toggled.
 *
 * This method will generate the "checked" tag attribute according to the form attribute value.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.checkbox.html#input.checkbox
 */
final class Checkbox extends Widget
{
    use CommonAttribute;

    private bool $enclosedByLabel = true;

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
     * Specifies the form element the tag input element belongs to. The value of this attribute must be the id
     * attribute of a {@see Form} element in the same document.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fae-form
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
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#the-label-element
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
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function labelAttributes(array $value = []): self
    {
        $new = clone $this;
        $new->attributes['labelAttributes'] = $value;
        return $new;
    }

    /**
     * @return string the generated checkbox tag.
     */
    protected function run(): string
    {
        $new = clone $this;

        $checkbox = CheckboxTag::tag();

        /** @var bool|float|int|string|Stringable|null  */
        $forceUncheckedValue = $new->attributes['forceUncheckedValue'] ?? null;

        unset($new->attributes['forceUncheckedValue']);

        $value = $new->getValue();

        if (is_iterable($value) || is_object($value)) {
            throw new InvalidArgumentException('The value must be a bool|float|int|string|Stringable|null.');
        }

        if ($new->enclosedByLabel === true) {
            /** @var string */
            $label = $new->attributes['label'] ?? $new->getLabel();

            /** @var array */
            $labelAttributes = $new->attributes['labelAttributes'] ?? [];

            unset($new->attributes['label'], $new->attributes['labelAttributes']);

            $checkbox = $checkbox->label($label, $labelAttributes);
        }

        return $checkbox
            ->attributes($new->attributes)
            ->checked((bool) $value)
            ->id($new->getId())
            ->name($new->getInputName())
            ->uncheckValue($forceUncheckedValue)
            ->value((int) $new->getValue())
            ->render();
    }
}
