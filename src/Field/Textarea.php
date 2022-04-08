<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\AbstractInputField;
use Yiisoft\Form\Field\Base\PlaceholderTrait;
use Yiisoft\Html\Html;

use function is_string;

final class Textarea extends AbstractInputField
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
     * Name of form control to use for sending the element's directionality in form submission
     *
     * @param string|null $value Any string that is not empty.
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-dirname
     */
    public function dirname(?string $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['dirname'] = $value;
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
     * The expected maximum number of characters per line of text to show.
     *
     * @link https://html.spec.whatwg.org/multipage/form-elements.html#attr-textarea-cols
     */
    public function cols(?int $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['cols'] = $value;
        return $new;
    }

    /**
     * The number of lines of text to show.
     *
     * @link https://html.spec.whatwg.org/multipage/form-elements.html#attr-textarea-rows
     */
    public function rows(?int $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['rows'] = $value;
        return $new;
    }

    /**
     * Define how the value of the form control is to be wrapped for form submission:
     *  - `hard` indicates that the text in the `textarea` is to have newlines added by the user agent so that the text
     *    is wrapped when it is submitted.
     *  - `soft` indicates that the text in the `textarea` is not to be wrapped when it is submitted (though it can
     *    still be wrapped in the rendering).
     *
     * @link https://html.spec.whatwg.org/multipage/form-elements.html#attr-textarea-wrap
     */
    public function wrap(?string $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['wrap'] = $value;
        return $new;
    }

    protected function generateInput(): string
    {
        $value = $this->getAttributeValue();

        if (!is_string($value) && $value !== null) {
            throw new InvalidArgumentException('Textarea widget must be a string or null value.');
        }

        $tagAttributes = $this->getInputTagAttributes();

        /** @psalm-suppress MixedArgumentTypeCoercion */
        return Html::textarea($this->getInputName(), $value, $tagAttributes)->render();
    }
}
