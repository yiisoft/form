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
        $new = clone $this;
        $new->items = $value;
        return $new;
    }

    public function multiple(bool $value): self
    {
        $new = clone $this;
        $new->multiple = $value;
        return $new;
    }

    public function unselect(?string $value): self
    {
        $new = clone $this;
        $new->unselect = $value;
        return $new;
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
