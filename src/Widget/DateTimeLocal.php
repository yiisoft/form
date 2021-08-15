<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Yiisoft\Form\Widget\Attribute\CommonAttribute;
use Yiisoft\Form\Widget\Attribute\DateAttribute;
use Yiisoft\Html\Tag\Input;

/*
 * The input element with a type attribute whose value is "datetime-local" represents a control for setting the
 * element’s value to a string representing a local date and time (with no timezone information).
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.datetime-local.html#input.datetime-local
 */
final class DateTimeLocal extends Widget
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
            throw new InvalidArgumentException('DateTimeLocal widget requires a string value.');
        }

        return Input::tag()
            ->type('datetime-local')
            ->attributes($new->attributes)
            ->id($new->getId())
            ->name($new->getInputName())
            ->value($value)
            ->render();
    }
}
