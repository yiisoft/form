<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\AbstractField;
use Yiisoft\Form\Field\Base\MinMaxTrait;
use Yiisoft\Form\Field\Base\PlaceholderTrait;
use Yiisoft\Form\Field\Base\ReadonlyTrait;
use Yiisoft\Form\Field\Base\RequiredTrait;
use Yiisoft\Html\Html;

/**
 * A control for setting the element's value to a string representing a number.
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#number-state-(type=number)
 */
final class Number extends AbstractField
{
    use MinMaxTrait;
    use PlaceholderTrait;
    use ReadonlyTrait;
    use RequiredTrait;

    protected function generateInput(): string
    {
        $value = $this->getAttributeValue();

        if (!is_numeric($value) && $value !== null) {
            throw new InvalidArgumentException('Number widget must be a numeric or null value.');
        }

        $tagAttributes = $this->getInputTagAttributes();

        /** @psalm-suppress MixedArgumentTypeCoercion */
        return Html::input('number', $this->getInputName(), $value)
            ->attributes($tagAttributes)
            ->render();
    }
}
