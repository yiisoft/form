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

final class Email extends AbstractField
{
    use MinMaxLengthTrait;
    use PatternTrait;
    use PlaceholderTrait;
    use ReadonlyTrait;
    use RequiredTrait;
    use SizeTrait;

    /**
     * Allow to specify more than one value.
     *
     * @param bool $value Whether the user is to be allowed to specify more than one value.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-multiple
     */
    public function multiple(bool $value = true): self
    {
        $new = clone $this;
        $new->inputTagAttributes['multiple'] = $value;
        return $new;
    }

    protected function generateInput(): string
    {
        $value = $this->getAttributeValue();

        if (!is_string($value) && $value !== null) {
            throw new InvalidArgumentException('Email widget must be a string or null value.');
        }

        $tagAttributes = $this->getInputTagAttributes();

        /** @psalm-suppress MixedArgumentTypeCoercion */
        return Html::input('email', $this->getInputName(), $value)
            ->attributes($tagAttributes)
            ->render();
    }
}
