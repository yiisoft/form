<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Collection;

trait InputOptions
{
    public function autofocus(bool $value = true): self
    {
        $new = clone $this;
        $new->options['autofocus'] = $value;
        return $new;
    }

    public function addDisabled(bool $value = true): self
    {
        $new = clone $this;
        $new->options['disabled'] = $value;
        return $new;
    }

    public function addItemOptions(array $value = []): self
    {
        $new = clone $this;
        $new->options['itemOptions'] = $value;
        return $new;
    }

    public function addMaxLength(int $value): self
    {
        $new = clone $this;
        $new->options['maxlength'] = $value;
        return $new;
    }

    public function addMultiple(bool $value): self
    {
        $new = clone $this;
        $new->options['multiple'] = $value;
        return $new;
    }

    public function addSize(int $value = 4): self
    {
        $new = clone $this;
        $new->options['size'] = $value;
        return $new;
    }

    public function addRequired(bool $value = true): self
    {
        $new = clone $this;
        $new->options['required'] = $value;
        return $new;
    }

    public function addTabIndex(int $value = 0): self
    {
        $new = clone $this;
        $new->options['tabindex'] = $value;
        return $new;
    }

    public function addUncheck(bool $value = true): self
    {
        $new = clone $this;

        if ($value) {
            $new->options['uncheck'] = '0';
        } else {
            unset($this->options['uncheck']);
        }

        return $new;
    }

    public function addUnselect(string $value = ''): self
    {
        $new = clone $this;
        $new->options['unselect'] = $value;
        return $new;
    }
}
