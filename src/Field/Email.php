<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\AbstractInputField;
use Yiisoft\Form\Field\Base\PlaceholderTrait;
use Yiisoft\Html\Html;

use function is_string;

final class Email extends AbstractInputField
{
    use PlaceholderTrait;

    /**
     * Maximum length of value.
     *
     * @param int $value A limit on the number of characters a user can input.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-maxlength
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-maxlength
     */
    public function maxlength(int $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['maxlength'] = $value;
        return $new;
    }

    /**
     * Minimum length of value.
     *
     * @param int $value A lower bound on the number of characters a user can input.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-minlength
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-minlength
     */
    public function minlength(int $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['minlength'] = $value;
        return $new;
    }

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

    /**
     * Pattern to be matched by the form control's value.
     *
     * @param string $value A regular expression against which the control's value.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-pattern
     */
    public function pattern(string $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['pattern'] = $value;
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
     * The size of the control.
     *
     * @param int $value The number of characters that allow the user to see while editing the element's value.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-size
     */
    public function size(int $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['size'] = $value;
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
