<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Form\Field\Base\PlaceholderTrait;
use Yiisoft\Html\Html;

/**
 * A control for setting the element's value to a string representing a number.
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#number-state-(type=number)
 */
final class Number extends InputField
{
    use PlaceholderTrait;

    /**
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-max
     */
    public function max(?string $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['max'] = $value;
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-min
     */
    public function min(?string $value): self
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
    public function readonly(bool $value = true): self
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
    public function required(bool $value = true): self
    {
        $new = clone $this;
        $new->inputTagAttributes['required'] = $value;
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-disabled
     */
    public function disabled(bool $disabled = true): self
    {
        $new = clone $this;
        $new->inputTagAttributes['disabled'] = $disabled;
        return $new;
    }

    protected function generateInput(): string
    {
        $value = $this->getAttributeValue();

        if (!is_numeric($value) && $value !== null) {
            throw new InvalidArgumentException('Number widget must be a numeric or null value.');
        }

        $tagAttributes = $this->getInputTagAttributes();

        return Html::input('number', $this->getInputName(), $value, $tagAttributes)->render();
    }
}
