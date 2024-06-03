<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Part;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Form\Field\Base\InputData\InputDataTrait;
use Yiisoft\Form\Theme\ThemeContainer;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

/**
 * Represents hint for a form field.
 */
final class Hint extends Widget
{
    use InputDataTrait;

    /**
     * @psalm-var non-empty-string
     */
    private string $tag = 'div';
    private array $attributes = [];

    private string|Stringable|null $content = null;

    private bool $encode = true;

    /**
     * Set the container tag name for the hint.
     *
     * @param string $tag Container tag name.
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

    public function addAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = array_merge($this->attributes, $attributes);
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
     * Replace tag CSS classes with a new set of classes.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    public function class(?string ...$class): self
    {
        $new = clone $this;
        $new->attributes['class'] = array_filter($class, static fn ($c) => $c !== null);
        return $new;
    }

    /**
     * Add one or more CSS classes to the tag.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    public function addClass(?string ...$class): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, $class);
        return $new;
    }

    public function content(string|Stringable|null $content): self
    {
        $new = clone $this;
        $new->content = $content;
        return $new;
    }

    /**
     * Whether content should be HTML-encoded.
     */
    public function encode(bool $value): self
    {
        $new = clone $this;
        $new->encode = $value;
        return $new;
    }

    public function render(): string
    {
        $content = $this->content ?? $this->getInputData()->getHint();

        return empty($content)
            ? ''
            : Html::tag($this->tag, $content, $this->attributes)
                ->encode($this->encode)
                ->render();
    }

    protected static function getThemeConfig(?string $theme): array
    {
        return ThemeContainer::getTheme($theme)?->getHintConfig() ?? [];
    }
}
