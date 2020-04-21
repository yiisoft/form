<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Collection;

trait BooleanOptions
{
    private bool $label = true;
    private bool $uncheck = false;

    public function label(bool $value): self
    {
        $immutable = clone $this;
        $immutable->label = $value;
        return $immutable;
    }

    public function uncheck(bool $value): self
    {
        $immutable = clone $this;
        $immutable->uncheck = $value;
        return $immutable;
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
