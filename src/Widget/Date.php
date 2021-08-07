<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Yiisoft\Form\Widget\Attribute\CommonAttribute;
use Yiisoft\Form\Widget\Attribute\DateAttribute;
use Yiisoft\Html\Tag\Input;

/*
 * The input element with a type attribute whose value is "date" represents a control for setting the element’s value to
 * a string representing a date.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.date.html#input.date
 */
final class Date extends Widget
{
    use CommonAttribute;
    use DateAttribute;

    /**
     * Generates a datepicker tag together with a label for the given form attribute.
     *
     * @return string the generated checkbox tag.
     */
    protected function run(): string
    {
        $new = clone $this;

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.date.html#input.date.attrs.value */
        $value = $new->getValue();

        if (!is_string($value)) {
            throw new InvalidArgumentException('Date widget requires a string value.');
        }

        return Input::tag()
            ->type('date')
            ->attributes($new->attributes)
            ->id($new->getId())
            ->name($new->getInputName())
            ->value($value)
            ->render();
    }
}
