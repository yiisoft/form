<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Validator;

interface NumberInterface
{
    /**
     * The expected upper bound for the element’s value.
     *
     * @param int $value
     *
     * @return self
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.number.html#input.number.attrs.max
     */
    public function max(int $value): self;

    /**
     * The expected lower bound for the element’s value.
     *
     * @param int $value
     *
     * @return self
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.number.html#input.number.attrs.min
     */
    public function min(int $value): self;
}
