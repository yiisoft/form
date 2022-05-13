<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Part;

use Stringable;
use Yiisoft\Form\Field\Base\FormAttributeTrait;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

/**
 * Represents label for a form field.
 */
final class Label extends Widget
{
    use FormAttributeTrait;

    private array $tagAttributes = [];

    private bool $setForAttribute = true;

    private ?string $forId = null;
    private bool $useInputIdAttribute = true;

    private string|Stringable|null $content = null;

    private bool $encode = true;

    /**
     * @return static
     */
    public function tagAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->tagAttributes = $attributes;
        return $new;
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
     * @return static
     */
    public function content(string|Stringable|null $content): self
    {
        $new = clone $this;
        $new->content = $content;
        return $new;
    }

    /**
     * Whether content should be HTML-encoded.
     *
     * @return static
     */
    public function encode(bool $value): self
    {
        $new = clone $this;
        $new->encode = $value;
        return $new;
    }

    protected function run(): string
    {
        $useModel = $this->hasFormModelAndAttribute();

        $content = $useModel
            ? $this->content ?? $this->getAttributeLabel()
            : (string) $this->content;

        if ($content === '') {
            return '';
        }

        $tagAttributes = $this->tagAttributes;

        if ($this->setForAttribute && !isset($tagAttributes['for'])) {
            $id = $this->forId;
            if ($useModel && $id === null && $this->useInputIdAttribute) {
                $id = $this->getInputId();
            }
            if ($id !== null) {
                $tagAttributes['for'] = $id;
            }
        }

        $tag = Html::label($content)->attributes($tagAttributes);

        if (!$this->encode) {
            $tag = $tag->encode(false);
        }

        return $tag->render();
    }
}
