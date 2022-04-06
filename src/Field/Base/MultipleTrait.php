<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

trait MultipleTrait
{
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
}
