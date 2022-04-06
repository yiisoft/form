<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

/**
 * @psalm-require-extends AbstractField
 */
trait MinMaxTrait
{
    /**
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-max
     */
    final public function max(?string $value): static
    {
        $new = clone $this;
        $new->inputTagAttributes['max'] = $value;
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-min
     */
    final public function min(?string $value): static
    {
        $new = clone $this;
        $new->inputTagAttributes['min'] = $value;
        return $new;
    }
}
