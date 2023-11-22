<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base\Placeholder;

use Yiisoft\Form\Field\Base\InputData\InputDataInterface;

/**
 * @psalm-require-extends \Yiisoft\Form\Field\Base\InputField
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

    protected function preparePlaceholderInInputAttributes(array &$attributes): void
    {
        if (
            $this->usePlaceholder
            && !isset($attributes['placeholder'])
        ) {
            $placeholder = $this->placeholder ?? $this->getInputData()->getPlaceholder();
            if ($placeholder !== null) {
                $attributes['placeholder'] = $placeholder;
            }
        }
    }

    abstract protected function getInputData(): InputDataInterface;
}
