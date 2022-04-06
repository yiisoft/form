<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

/**
 * @psalm-require-extends AbstractField
 */
trait PatternTrait
{
    /**
     * Pattern to be matched by the form control's value.
     *
     * @param string $value A regular expression against which the control's value.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-pattern
     */
    public function pattern(string $value): static
    {
        $new = clone $this;
        $new->inputTagAttributes['pattern'] = $value;
        return $new;
    }
}
