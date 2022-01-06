<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

/**
 * @psalm-import-type HtmlAttributes from \Yiisoft\Html\Html
 * @psalm-require-extends AbstractField
 */
trait PlaceholderTrait
{
    private ?string $placeholder = null;
    private bool $usePlaceholder = true;

    public function placeholder(?string $placeholder): self
    {
        $new = clone $this;
        $new->placeholder = $placeholder;
        return $new;
    }

    public function usePlaceholder(bool $use): self
    {
        $new = clone $this;
        $new->usePlaceholder = $use;
        return $new;
    }

    /**
     * @psalm-param HtmlAttributes $attributes
     */
    protected function preparePlaceholderInFormElementTagAttributes(array &$attributes): void
    {
        if (
            $this->usePlaceholder
            && !isset($attributes['placeholder'])
        ) {
            $placeholder = $this->placeholder ?? $this->getAttributePlaceholder();
            if ($placeholder !== null) {
                $attributes['placeholder'] = $placeholder;
            }
        }
        /** @psalm-var HtmlAttributes $attributes */
    }
}
