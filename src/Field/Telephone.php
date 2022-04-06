<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\AbstractField;
use Yiisoft\Form\Field\Base\MinMaxLengthTrait;
use Yiisoft\Form\Field\Base\PatternTrait;
use Yiisoft\Form\Field\Base\PlaceholderTrait;
use Yiisoft\Form\Field\Base\ReadonlyTrait;
use Yiisoft\Form\Field\Base\RequiredTrait;
use Yiisoft\Form\Field\Base\SizeTrait;
use Yiisoft\Html\Html;

use function is_string;

/**
 * @link https://html.spec.whatwg.org/multipage/input.html#telephone-state-(type=tel)
 */
final class Telephone extends AbstractField
{
    use MinMaxLengthTrait;
    use PatternTrait;
    use PlaceholderTrait;
    use ReadonlyTrait;
    use RequiredTrait;
    use SizeTrait;

    protected function generateInput(): string
    {
        $value = $this->getAttributeValue();

        if (!is_string($value) && $value !== null) {
            throw new InvalidArgumentException('Telephone widget must be a string or null value.');
        }

        $tagAttributes = $this->getInputTagAttributes();

        /** @psalm-suppress MixedArgumentTypeCoercion */
        return Html::input('tel', $this->getInputName(), $value)
            ->attributes($tagAttributes)
            ->render();
    }
}
