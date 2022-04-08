<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\AbstractInputField;
use Yiisoft\Html\Html;

use function is_string;

/**
 * The input element with a type attribute whose value is "hidden" represents a value that is not intended to be
 * examined or manipulated by the user.
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#hidden-state-(type=hidden)
 */
final class Hidden extends AbstractInputField
{
    protected bool $useContainer = false;
    protected string $template = '{input}';

    protected function generateInput(): string
    {
        $value = $this->getAttributeValue();

        if (!is_string($value) && !is_numeric($value) && $value !== null) {
            throw new InvalidArgumentException('Hidden widget requires a string, numeric or null value.');
        }

        $tagAttributes = $this->getInputTagAttributes();

        /** @psalm-suppress MixedArgumentTypeCoercion */
        return Html::hiddenInput($this->getInputName(), $value, $tagAttributes)->render();
    }
}
