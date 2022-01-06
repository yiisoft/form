<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Form\Widget\Attribute\InputAttributes;
use Yiisoft\Html\Tag\Input\Checkbox as CheckboxTag;

/**
 * The input element with a type attribute whose value is "checkbox" represents a state or option that can be toggled.
 *
 * This method will generate the "checked" tag attribute according to the form attribute value.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.checkbox.html#input.checkbox
 */
final class Checkbox extends InputAttributes
{
    private bool $checked = false;
    private bool $enclosedByLabel = true;
    private ?string $label = '';
    private array $labelAttributes = [];
    /** @var bool|float|int|string|Stringable|null */
    private $uncheckValue = '0';

    /**
     * Check the checkbox button.
     *
     * @param bool $value Whether the checkbox button is checked.
     *
     * @return static
     */
    public function checked(bool $value = true): self
    {
        $new = clone $this;
        $new->checked = $value;
        return $new;
    }

    /**
     * If the widget should be enclosed by label.
     *
     * @param bool $value If the widget should be en closed by label.
     *
     * @return static
     */
    public function enclosedByLabel(bool $value): self
    {
        $new = clone $this;
        $new->enclosedByLabel = $value;
        return $new;
    }

    /**
     * Label displayed next to the checkbox.
     *
     * It will NOT be HTML-encoded, therefore you can pass in HTML code such as an image tag. If this is coming from
     * end users, you should {@see encode()} it to prevent XSS attacks.
     *
     * When this option is specified, the checkbox will be enclosed by a label tag.
     *
     * @param string|null $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#the-label-element
     */
    public function label(?string $value): self
    {
        $new = clone $this;
        $new->label = $value;
        return $new;
    }

    /**
     * HTML attributes for the label tag.
     *
     * Do not set this option unless you set the "label" attributes.
     *
     * @param array $attributes
     *
     * @return static
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function labelAttributes(array $attributes = []): self
    {
        $new = clone $this;
        $new->labelAttributes = $attributes;
        return $new;
    }

    /**
     * @param bool|float|int|string|Stringable|null $value Value that corresponds to "unchecked" state of the input.
     *
     * @return static
     */
    public function uncheckValue($value): self
    {
        $new = clone $this;
        $new->uncheckValue = is_bool($value) ? (int) $value : $value;
        return $new;
    }

    /**
     * @return string the generated checkbox tag.
     */
    protected function run(): string
    {
        $attributes = $this->build($this->attributes);

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.checkbox.html#input.checkbox.attrs.value */
        $value = $this->getAttributeValue();

        /** @var iterable<int, scalar|Stringable>|scalar|Stringable|null */
        $valueDefault = array_key_exists('value', $attributes) ? $attributes['value'] : null;

        if (is_iterable($value) || is_object($value) || is_iterable($valueDefault) || is_object($valueDefault)) {
            throw new InvalidArgumentException('Checkbox widget value can not be an iterable or an object.');
        }

        $checkbox = CheckboxTag::tag();

        if ($this->enclosedByLabel === true) {
            $checkbox = $checkbox->label(
                empty($this->label) ? $this->getAttributeLabel() : $this->label,
                $this->labelAttributes,
            );
        }

        if (empty($value)) {
            $checkbox = $checkbox->checked($this->checked);
        } else {
            $checkbox = $checkbox->checked("$value" === "$valueDefault");
        }

        return $checkbox
            ->attributes($attributes)
            ->uncheckValue($this->uncheckValue)
            ->value(is_bool($valueDefault) ? (int) $valueDefault : $valueDefault)
            ->render();
    }
}
