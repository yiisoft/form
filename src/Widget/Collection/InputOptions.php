<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Collection;

/**
 * Form input options
 */
trait InputOptions
{
    public function autofocus(bool $value = true): self
    {
        $new = clone $this;
        $new->options['autofocus'] = $value;
        return $new;
    }

    public function disabled(bool $value = true): self
    {
        $new = clone $this;
        $new->options['disabled'] = $value;
        return $new;
    }

    public function itemOptions(array $value = []): self
    {
        $new = clone $this;
        $new->options['itemOptions'] = $value;
        return $new;
    }

    public function maxLength(int $value): self
    {
        $new = clone $this;
        $new->options['maxlength'] = $value;
        return $new;
    }

    public function multiple(bool $value): self
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

    public function required(bool $value = true): self
    {
        $new = clone $this;
        $new->options['required'] = $value;
        return $new;
    }

    public function tabIndex(int $value = 0): self
    {
        $new = clone $this;
        $new->options['tabindex'] = $value;
        return $new;
    }

    public function uncheck(bool $value = true): self
    {
        $new = clone $this;

        if ($value) {
            $new->options['uncheck'] = '0';
        } else {
            unset($new->options['uncheck']);
        }

        return $new;
    }

    public function unselect(string $value = ''): self
    {
        $new = clone $this;
        $new->options['unselect'] = $value;
        return $new;
    }
}
