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

    private array $attributes = [];

    private bool $setFor = true;

    private ?string $forId = null;
    private bool $useInputId = true;

    private string|Stringable|null $content = null;

    private bool $encode = true;

    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = array_merge($this->attributes, $attributes);
        return $new;
    }

    public function replaceAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;
        return $new;
    }

    /**
     * Set tag ID.
     *
     * @param string|null $id Tag ID.
     */
    public function id(?string $id): self
    {
        $new = clone $this;
        $new->attributes['id'] = $id;
        return $new;
    }

    /**
     * Add one or more CSS classes to the tag.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    public function class(?string ...$class): self
    {
        $new = clone $this;
        Html::addCssClass(
            $new->attributes,
            array_filter($class, static fn ($c) => $c !== null),
        );
        return $new;
    }

    /**
     * Replace tag CSS classes with a new set of classes.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    public function replaceClass(?string ...$class): self
    {
        $new = clone $this;
        $new->attributes['class'] = array_filter($class, static fn ($c) => $c !== null);
        return $new;
    }

    public function setFor(bool $value): self
    {
        $new = clone $this;
        $new->setFor = $value;
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
    public function useInputId(bool $value): self
    {
        $new = clone $this;
        $new->useInputId = $value;
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
            ? $this->content ?? $this->getFormAttributeLabel()
            : (string) $this->content;

        if ($content === '') {
            return '';
        }

        $labelAttributes = $this->attributes;

        if ($this->setFor && !isset($labelAttributes['for'])) {
            $id = $this->forId;
            if ($useModel && $id === null && $this->useInputId) {
                $id = $this->getInputId();
            }
            if ($id !== null) {
                $labelAttributes['for'] = $id;
            }
        }

        $tag = Html::label($content)->attributes($labelAttributes);

        if (!$this->encode) {
            $tag = $tag->encode(false);
        }

        return $tag->render();
    }
}
