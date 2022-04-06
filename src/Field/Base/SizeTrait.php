<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

/**
 * @psalm-require-extends AbstractField
 */
trait SizeTrait
{
    /**
     * The size of the control.
     *
     * @param int $value The number of characters that allow the user to see while editing the element's value.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-size
     */
    public function size(int $value): static
    {
        $new = clone $this;
        $new->inputTagAttributes['size'] = $value;
        return $new;
    }
}
