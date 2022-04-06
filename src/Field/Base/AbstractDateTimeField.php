<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use InvalidArgumentException;
use ReflectionClass;
use Yiisoft\Html\Html;

use function is_string;

abstract class AbstractDateTimeField extends AbstractField
{
    use MinMaxTrait;
    use ReadonlyTrait;
    use RequiredTrait;

    final protected function generateInput(): string
    {
        $value = $this->getAttributeValue();

        if (!is_string($value) && $value !== null) {
            throw new InvalidArgumentException(
                (new ReflectionClass($this))->getShortName() .
                ' widget must be a string or null value.'
            );
        }

        $tagAttributes = $this->getInputTagAttributes();

        /** @psalm-suppress MixedArgumentTypeCoercion */
        return Html::input($this->getInputType(), $this->getInputName(), $value)
            ->attributes($tagAttributes)
            ->render();
    }

    abstract protected function getInputType(): string;
}
