<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use InvalidArgumentException;
use ReflectionClass;
use Yiisoft\Html\Html;

use function is_string;

abstract class AbstractDateTimeField extends AbstractInputField
{
    /**
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-max
     */
    final public function max(?string $value): static
    {
        $new = clone $this;
        $new->inputTagAttributes['max'] = $value;
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-min
     */
    final public function min(?string $value): static
    {
        $new = clone $this;
        $new->inputTagAttributes['min'] = $value;
        return $new;
    }

    /**
     * A boolean attribute that controls whether or not the user can edit the form control.
     *
     * @param bool $value Whether to allow the value to be edited by the user.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-readonly
     */
    final public function readonly(bool $value = true): static
    {
        $new = clone $this;
        $new->inputTagAttributes['readonly'] = $value;
        return $new;
    }

    /**
     * A boolean attribute. When specified, the element is required.
     *
     * @param bool $value Whether the control is required for form submission.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-required
     */
    final public function required(bool $value = true): static
    {
        $new = clone $this;
        $new->inputTagAttributes['required'] = $value;
        return $new;
    }

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
