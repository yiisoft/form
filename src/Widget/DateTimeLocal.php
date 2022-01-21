<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Yiisoft\Form\Widget\Attribute\InputAttributes;
use Yiisoft\Html\Tag\Input;

/*
 * The input element with a type attribute whose value is "datetime-local" represents a control for setting the
 * element’s value to a string representing a local date and time (with no timezone information).
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.datetime-local.html#input.datetime-local
 */
final class DateTimeLocal extends InputAttributes
{
    /**
     * The latest acceptable date.
     *
     * @param string|null $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.datetime-local.html#input.datetime-local.attrs.max
     */
    public function max(?string $value): self
    {
        $new = clone $this;
        $new->attributes['max'] = $value;
        return $new;
    }

    /**
     * The earliest acceptable date.
     *
     * @param string|null $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.datetime-local.html#input.datetime-local.attrs.min
     */
    public function min(?string $value): self
    {
        $new = clone $this;
        $new->attributes['min'] = $value;
        return $new;
    }

    /**
     * Generates a datepicker tag together with a label for the given form attribute.
     *
     * @return string the generated checkbox tag.
     */
    protected function run(): string
    {
        $attributes = $this->build($this->attributes);

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.datetime-local.html#input.datetime-local.attrs.value */
        $value = $attributes['value'] ?? $this->getAttributeValue();
        unset($attributes['value']);

        if (!is_string($value) && null !== $value) {
            throw new InvalidArgumentException('DateTimeLocal widget requires a string or null value.');
        }

        return Input::tag()
            ->type('datetime-local')
            ->attributes($attributes)
            ->value($value === '' ? null : $value)
            ->render();
    }
}
