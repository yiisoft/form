<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Yiisoft\Form\Field\Base\DateTimeInputField;

/**
 * Represents `<input>` element of type "datetime" are let the user enter a date and time (hour, minute, second, and
 * fraction of a second) as well as a timezone.
 *
 * @link https://www.w3.org/TR/2017/CR-html52-20170808/sec-forms.html#date-and-time-state-typedatetime
 * @link https://developer.mozilla.org/docs/Web/HTML/Element/input/datetime
 */
final class DateTime extends DateTimeInputField
{
    protected function getInputType(): string
    {
        return 'datetime';
    }
}
