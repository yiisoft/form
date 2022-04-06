<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

/**
 * @psalm-require-extends AbstractField
 */
trait DirnameTrait
{
    /**
     * Name of form control to use for sending the element's directionality in form submission
     *
     * @param string|null $value Any string that is not empty.
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-dirname
     */
    public function dirname(?string $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['dirname'] = $value;
        return $new;
    }

}
