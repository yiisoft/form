<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

/**
 * @psalm-require-extends AbstractField
 */
trait MinMaxLengthTrait
{
    /**
     * Maximum length of value.
     *
     * @param int $value A limit on the number of characters a user can input.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-maxlength
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-maxlength
     */
    public function maxlength(int $value): static
    {
        $new = clone $this;
        $new->inputTagAttributes['maxlength'] = $value;
        return $new;
    }

    /**
     * Minimum length of value.
     *
     * @param int $value A lower bound on the number of characters a user can input.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-minlength
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-minlength
     */
    public function minlength(int $value): static
    {
        $new = clone $this;
        $new->inputTagAttributes['minlength'] = $value;
        return $new;
    }
}
