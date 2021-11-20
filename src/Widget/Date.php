<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Form\Widget\Attribute\GlobalAttributes;
use Yiisoft\Html\Tag\Input;

/*
 * The input element with a type attribute whose value is "date" represents a control for setting the element’s value to
 * a string representing a date.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.date.html#input.date
 */
final class Date extends AbstractWidget
{
    use GlobalAttributes;

    /**
     * The latest acceptable date.
     *
     * @param string|null $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.date.html#input.date.attrs.max
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
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.date.html#input.date.attrs.min
     */
    public function min(?string $value): self
    {
        $new = clone $this;
        $new->attributes['min'] = $value;
        return $new;
    }

    /**
     * The readonly attribute is a boolean attribute that controls whether the user can edit the form control.
     * When specified, the element is not mutable.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.date.html#input.date.attrs.readonly
     */
    public function readonly(): self
    {
        $new = clone $this;
        $new->attributes['readonly'] = true;
        return $new;
    }

    /**
     * Generates a datepicker tag together with a label for the given form attribute.
     *
     * @return string the generated checkbox tag.
     */
    protected function run(): string
    {
        $new = clone $this;

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.date.html#input.date.attrs.value */
        $value = HtmlForm::getAttributeValue($new->getFormModel(), $new->getAttribute());

        if (!is_string($value) && null !== $value) {
            throw new InvalidArgumentException('Date widget requires a string or null value.');
        }

        return Input::tag()
            ->type('date')
            ->attributes($new->attributes)
            ->id($new->getId())
            ->name($new->getName())
            ->value($value === '' ? null : $value)
            ->render();
    }
}
