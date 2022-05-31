<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Yiisoft\Form\Widget\Attribute\InputAttributes;
use Yiisoft\Form\Widget\Attribute\PlaceholderInterface;
use Yiisoft\Form\Widget\Validator\HasLengthInterface;
use Yiisoft\Form\Widget\Validator\RegexInterface;
use Yiisoft\Html\Tag\Input;

use function is_string;

/**
 * The input element with a type attribute whose value is "password" represents a one-line plain-text edit control for
 * entering a password.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.password.html#input.password
 */
final class Password extends InputAttributes implements HasLengthInterface, RegexInterface, PlaceholderInterface
{
    public function maxlength(int $value): self
    {
        $new = clone $this;
        $new->attributes['maxlength'] = $value;
        return $new;
    }

    public function minlength(int $value): self
    {
        $new = clone $this;
        $new->attributes['minlength'] = $value;
        return $new;
    }

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
     * @return self
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.password.html#input.password.attrs.placeholder
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
     * @return self
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.password.html#input.password.attrs.size
     */
    public function size(int $size): self
    {
        $new = clone $this;
        $new->attributes['size'] = $size;
        return $new;
    }

    /**
     * Generates a password input tag for the given form attribute.
     *
     * @return string the generated input tag,
     */
    protected function run(): string
    {
        $attributes = $this->build($this->attributes);

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text.attrs.value */
        $value = $attributes['value'] ?? $this->getAttributeValue();
        unset($attributes['value']);

        if (null !== $value && !is_string($value)) {
            throw new InvalidArgumentException('Password widget must be a string or null value.');
        }

        return Input::tag()
            ->type('password')
            ->attributes($attributes)
            ->value($value === '' ? null : $value)
            ->render();
    }
}
