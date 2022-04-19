<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Yiisoft\Form\Field\Base\ButtonField;

/**
 * @link https://html.spec.whatwg.org/multipage/form-elements.html#attr-button-type-reset-state
 */
final class ResetButton extends ButtonField
{
    protected function getType(): string
    {
        return 'reset';
    }
}
