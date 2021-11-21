<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Form\Widget\Attribute\GlobalAttributes;
use Yiisoft\Html\Tag\Input;

/**
 * The input element with a type attribute whose value is "email" represents a control for editing a list of e-mail
 * addresses given in the element’s value.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.email.html#input.email
 */
final class Email extends AbstractForm
{
    use GlobalAttributes;

    /**
     * The maxlength attribute defines the maximum number of characters (as UTF-16 code units) the user can enter into
     * a tag input.
     *
     * If no maxlength is specified, or an invalid value is specified, the tag input has no maximum length.
     *
     * @param int $length Positive integer.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.email.html#input.email.attrs.maxlength
     */
    public function maxlength(int $length): self
    {
        $new = clone $this;
        $new->attributes['maxlength'] = $length;
        return $new;
    }

    /**
     * The minimum number of characters (as UTF-16 code units) the user can enter into the text input.
     *
     * This must be a non-negative integer value smaller than or equal to the value specified by maxlength.
     * If no minlength is specified, or an invalid value is specified, the text input has no minimum length.
     *
     * @param int $length
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-minlength
     */
    public function minlength(int $length): self
    {
        $new = clone $this;
        $new->attributes['minlength'] = $length;
        return $new;
    }

    /**
     * Specifies that the element allows multiple values.
     *
     * @param bool $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.email.html#input.attrs.multiple
     */
    public function multiple(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['multiple'] = $value;
        return $new;
    }

    /**
     * The pattern attribute, when specified, is a regular expression that the input's value must match in order for
     * the value to pass constraint validation. It must be a valid JavaScript regular expression, as used by the
     * RegExp type.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.email.html#input.email.attrs.pattern
     */
    public function pattern(string $value): self
    {
        $new = clone $this;
        $new->attributes['pattern'] = $value;
        return $new;
    }

    /**
     * It allows defining placeholder.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.email.html#input.email.attrs.placeholder
     */
    public function placeholder(string $value): self
    {
        $new = clone $this;
        $new->attributes['placeholder'] = $value;
        return $new;
    }

    /**
     * The number of options meant to be shown by the control represented by its element.
     *
     * @param int $size
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.email.html#input.email.attrs.size
     */
    public function size(int $size): self
    {
        $new = clone $this;
        $new->attributes['size'] = $size;
        return $new;
    }

    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $new = clone $this;

        /**
         * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.email.html#input.email.attrs.value.single
         * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.email.html#input.email.attrs.value.multiple
         */
        $value = HtmlForm::getAttributeValue($new->getFormModel(), $new->getAttribute());

        if (!is_string($value) && null !== $value) {
            throw new InvalidArgumentException('Email widget must be a string or null value.');
        }

        return Input::tag()
            ->type('email')
            ->attributes($new->attributes)
            ->id($new->getId())
            ->name($new->getName())
            ->value($value === '' ? null : $value)
            ->render();
    }
}
