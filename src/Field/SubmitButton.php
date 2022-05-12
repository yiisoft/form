<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Yiisoft\Form\Field\Base\ButtonField;

/**
 * Represents `<button>` element of type "submit" are rendered as button for submitting a form.
 *
 * @link https://html.spec.whatwg.org/multipage/form-elements.html#attr-button-type-submit-state
 * @link https://developer.mozilla.org/docs/Web/HTML/Element/button
 */
final class SubmitButton extends ButtonField
{
    protected function getType(): string
    {
        return 'submit';
    }
}
