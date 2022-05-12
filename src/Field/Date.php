<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Yiisoft\Form\Field\Base\DateTimeInputField;

/**
 * Represents `<input>` element of type "date" are let the user enter a date, either with a textbox that validates
 * the input or a special date picker interface.
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#date-state-(type=date)
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/date
 */
final class Date extends DateTimeInputField
{
    protected function getInputType(): string
    {
        return 'date';
    }
}
