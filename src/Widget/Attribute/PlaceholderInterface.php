<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Attribute;

interface PlaceholderInterface
{
    /**
     * It allows defining placeholder.
     *
     * @param string $value
     *
     * @return self
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#the-placeholder-attribute
     */
    public function placeholder(string $value): self;
}
