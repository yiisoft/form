<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Yiisoft\Form\Field\Base\ButtonField;

/**
 * Represents `<button>` element of type "button" are rendered as button without default behavior.
 *
 * @link https://html.spec.whatwg.org/multipage/form-elements.html#attr-button-type-button-state
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/button
 */
final class Button extends ButtonField
{
    protected function getType(): string
    {
        return 'button';
    }
}
