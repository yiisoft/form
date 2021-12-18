<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

trait PlaceholderTrait
{
    private ?string $placeholder = null;
    private bool $setPlaceholder = true;

    public function placeholder(?string $placeholder): self
    {
        $new = clone $this;
        $new->placeholder = $placeholder;
        return $new;
    }

    public function doNotSetPlaceholder(): self
    {
        $new = clone $this;
        $new->setPlaceholder = false;
        return $new;
    }

    protected function preparePlaceholderInInputTagAttributes(array &$attributes): void
    {
        if (
            $this->setPlaceholder
            && !isset($attributes['placeholder'])
        ) {
            $placeholder = $this->placeholder ?? $this->getAttributePlaceholder();
            if ($placeholder !== null) {
                $attributes['placeholder'] = $placeholder;
            }
        }
    }
}
