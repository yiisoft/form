<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use Yiisoft\Html\Tag\Base\Tag;

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

    protected function preparePlaceholderInInputTag(Tag $tag): Tag
    {
        if (
            $this->setPlaceholder
            && $tag->getAttribute('placeholder') === null
        ) {
            $placeholder = $this->placeholder ?? $this->getAttributePlaceholder();
            if ($placeholder !== null) {
                $tag = $tag->attribute('placeholder', $placeholder);
            }
        }

        return $tag;
    }
}
