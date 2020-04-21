<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Collection;

trait ListOptions
{
    private array $items = [];
    private bool $multiple = false;
    protected ?string $unselect = '';

    public function items(array $value): self
    {
        $immutable = clone $this;
        $immutable->items = $value;
        return $immutable;
    }

    public function multiple(bool $value): self
    {
        $immutable = clone $this;
        $immutable->multiple = $value;
        return $immutable;
    }

    public function unselect(?string $value): self
    {
        $immutable = clone $this;
        $immutable->unselect = $value;
        return $immutable;
    }

    private function addMultiple(): void
    {
        if ($this->multiple) {
            $this->options['multiple'] = $this->multiple;
        }
    }

    private function addUnselect(): void
    {
        if ($this->unselect !== null) {
            $this->options['unselect'] = $this->unselect;
        }
    }
}
