<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Yiisoft\Form\Field\Base\DateTimeInputField;

/**
 * @link https://www.w3.org/TR/2017/CR-html52-20170808/sec-forms.html#date-and-time-state-typedatetime
 */
final class DateTime extends DateTimeInputField
{
    protected function getInputType(): string
    {
        return 'datetime';
    }
}
