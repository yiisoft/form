<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\AbstractField;

use Yiisoft\Html\Html;

use function is_string;

/**
 * Generates a date input tag for the given form attribute.
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#date-state-(type=date)
 */
final class Date extends AbstractField
{
    /**
     * The latest acceptable date.
     */
    public function max(?string $date): self
    {
        $new = clone $this;
        $new->inputTagAttributes['max'] = $date;
        return $new;
    }

    /**
     * The earliest acceptable date.
     */
    public function min(?string $date): self
    {
        $new = clone $this;
        $new->inputTagAttributes['min'] = $date;
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
     * Identifies the element (or elements) that describes the object.
     *
     * @link https://w3c.github.io/aria/#aria-describedby
     */
    public function ariaDescribedBy(string $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['aria-describedby'] = $value;
        return $new;
    }

    /**
     * Defines a string value that labels the current element.
     *
     * @link https://w3c.github.io/aria/#aria-label
     */
    public function ariaLabel(string $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['aria-label'] = $value;
        return $new;
    }

    /**
     * Specifies the form element the tag input element belongs to. The value of this attribute must be the ID
     * attribute of a form element in the same document.
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fae-form
     */
    public function form(string $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['form'] = $value;
        return $new;
    }

    protected function generateInput(): string
    {
        $value = $this->getAttributeValue();

        if (!is_string($value) && $value !== null) {
            throw new InvalidArgumentException('Date widget must be a string or null value.');
        }

        $tagAttributes = $this->getInputTagAttributes();

        /** @psalm-suppress MixedArgumentTypeCoercion */
        return Html::input('date', $this->getInputName(), $value)
            ->attributes($tagAttributes)
            ->render();
    }
}
