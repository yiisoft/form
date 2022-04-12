<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Yiisoft\Form\Field\Base\AbstractButtonField;

/**
 * @link https://html.spec.whatwg.org/multipage/form-elements.html#attr-button-type-button-state
 */
final class Button extends AbstractButtonField
{
    protected function getType(): string
    {
        return 'button';
    }
}
