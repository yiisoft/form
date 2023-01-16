<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Yiisoft\Form\Field\Base\DateTimeInputField;

/**
 * Represents `<input>` element of type "time" are let the user enter a time (hour, minute, second, and fraction of a
 * second).
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#time-state-(type=time)
 * @link https://developer.mozilla.org/docs/Web/HTML/Element/input/time
 */
final class Time extends DateTimeInputField
{
    protected function getInputType(): string
    {
        return 'time';
    }
}
