<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Validator;

interface MatchRegularInterface
{
    /**
     * The pattern attribute, when specified, is a regular expression that the input's value must match in order for
     * the value to pass constraint validation. It must be a valid JavaScript regular expression, as used by the
     * RegExp type.
     *
     * @param string $value
     *
     * @return self
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text.attrs.pattern
     */
    public function pattern(string $value): self;
}
