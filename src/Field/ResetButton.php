<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Yiisoft\Form\Field\Base\ButtonField;

/**
 * Represents `<button>` element of type "reset" are rendered as button for resets all the controls to their initial
 * values.
 *
 * @link https://html.spec.whatwg.org/multipage/form-elements.html#attr-button-type-reset-state
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/button
 */
final class ResetButton extends ButtonField
{
    protected function getType(): string
    {
        return 'reset';
    }
}
