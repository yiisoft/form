<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Yiisoft\Form\Widget\Attribute\InputAttributes;
use Yiisoft\Form\Widget\Attribute\PlaceholderInterface;
use Yiisoft\Form\Widget\Validator\NumberInterface;
use Yiisoft\Html\Tag\Input;

use function array_key_exists;
use function is_numeric;

/**
 * The input element with a type attribute whose value is "number" represents a precise control for setting the
 * element’s value to a string representing a number.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.number.html
 */
final class Number extends InputAttributes implements NumberInterface, PlaceholderInterface
{
    public function max(int $value): self
    {
        $new = clone $this;
        $new->attributes['max'] = $value;
        return $new;
    }

    public function min(int $value): self
    {
        $new = clone $this;
        $new->attributes['min'] = $value;
        return $new;
    }

    public function placeholder(string $value): self
    {
        $new = clone $this;
        $new->attributes['placeholder'] = $value;
        return $new;
    }

    /**
     * @return string the generated input tag.
     */
    protected function run(): string
    {
        $attributes = $this->build($this->attributes);

        /** @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.number.html#input.number.attrs.value */
        $value = array_key_exists('value', $attributes) ? $attributes['value'] : $this->getAttributeValue();
        unset($attributes['value']);

        if (!is_numeric($value) && null !== $value) {
            throw new InvalidArgumentException('Number widget must be a numeric or null value.');
        }

        return Input::tag()
            ->type('number')
            ->attributes($attributes)
            ->value($value)
            ->render();
    }
}
