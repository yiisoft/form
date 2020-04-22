<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Collection;

trait BooleanOptions
{
    private bool $label = true;
    private bool $uncheck = false;

    public function label(bool $value): self
    {
        $new = clone $this;
        $new->label = $value;
        return $new;
    }

    public function uncheck(bool $value): self
    {
        $new = clone $this;
        $new->uncheck = $value;
        return $new;
    }

    private function addUncheck(): void
    {
        if ($this->uncheck) {
            $this->options['uncheck'] = '0';
        } else {
            unset($this->options['uncheck']);
        }
    }
}
