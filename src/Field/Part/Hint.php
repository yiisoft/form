<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Part;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Form\Field\Base\FormAttributeTrait;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

final class Hint extends Widget
{
    use FormAttributeTrait;

    /**
     * @psalm-var non-empty-string
     */
    private string $tag = 'div';
    private array $attributes = [];

    /**
     * @var string|Stringable|null
     */
    private $content = null;

    private bool $encode = true;

    /**
     * Set the container tag name for the hint.
     *
     * @param string $tag Container tag name. Set to empty value to render error messages without container tag.
     *
     * @return static
     */
    public function tag(string $tag): self
    {
        if ($tag === '') {
            throw new InvalidArgumentException('Tag name cannot be empty.');
        }

        $new = clone $this;
        $new->tag = $tag;
        return $new;
    }

    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;
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

    /**
     * Whether content should be HTML-encoded.
     *
     * @param bool $value
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
        return Html::tag(
            $this->tag,
            $this->content ?? $this->getAttributeHint(),
            $this->attributes
        )
            ->encode($this->encode)
            ->render();
    }
}
