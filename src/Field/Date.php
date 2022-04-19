<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Yiisoft\Form\Field\Base\DateTimeInputField;

/**
 * Generates a date input tag for the given form attribute.
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#date-state-(type=date)
 */
final class Date extends DateTimeInputField
{
    protected function getInputType(): string
    {
        return 'date';
    }
}
