<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Part;

use Stringable;
use Yiisoft\Form\Field\Base\FormAttributeTrait;
use Yiisoft\Html\Tag\Label as LabelTag;
use Yiisoft\Widget\Widget;

final class Label extends Widget
{
    use FormAttributeTrait;

    private bool $setForAttribute = true;

    private ?string $forId = null;
    private bool $useInputIdAttribute = true;

    /**
     * @var string|Stringable|null
     */
    private $content = null;

    protected function run(): string
    {
        $tag = LabelTag::tag()->content(
            $this->content ?? $this->getAttributeLabel()
        );

        if (
            $this->setForAttribute
            && $this->useInputIdAttribute
            && $tag->getAttribute('for') === null
        ) {
            $tag = $tag->forId($this->forId ?? $this->getInputId());
        }

        return $tag->render();
    }

    public function setForAttribute(bool $value): self
    {
        $new = clone $this;
        $new->setForAttribute = $value;
        return $new;
    }

    /**
     * @return static
     */
    public function forId(?string $id): self
    {
        $new = clone $this;
        $new->forId = $id;
        return $new;
    }

    /**
     * @return static
     */
    public function useInputIdAttribute(bool $value): self
    {
        $new = clone $this;
        $new->useInputIdAttribute = $value;
        return $new;
    }

    /**
     * @param string|Stringable|null $content
     *
     * @return static
     */
    public function content($content): self
    {
        $new = clone $this;
        $new->content = $content;
        return $new;
    }
}
