<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Attribute;

trait DateAttribute
{
    /**
     * The earliest acceptable date.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-min
     */
    public function min(string $value): self
    {
        $new = clone $this;
        $new->attributes['min'] = $value;
        return $new;
    }

    /**
     * The latest acceptable date.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-max
     */
    public function max(string $value): self
    {
        $new = clone $this;
        $new->attributes['max'] = $value;
        return $new;
    }

    /**
     * The readonly attribute is a boolean attribute that controls whether or not the user can edit the form control.
     * When specified, the element is not mutable.
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#the-readonly-attribute
     */
    public function readonly(): self
    {
        $new = clone $this;
        $new->attributes['readonly'] = true;
        return $new;
    }
}
