<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use InvalidArgumentException;
use Yiisoft\Form\Theme\ThemeContainer;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Widget\Widget;

abstract class BaseField extends Widget
{
    /**
     * @psalm-var non-empty-string
     */
    protected string $containerTag = 'div';
    protected array $containerAttributes = [];
    protected bool $useContainer = true;
    protected array $enrichment = [];

    private bool $isStartedByBegin = false;

    final public function containerTag(string $tag): static
    {
        if ($tag === '') {
            throw new InvalidArgumentException('Tag name cannot be empty.');
        }

        $new = clone $this;
        $new->containerTag = $tag;
        return $new;
    }

    final public function containerAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->containerAttributes = $attributes;
        return $new;
    }

    final public function addContainerAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->containerAttributes = array_merge($new->containerAttributes, $attributes);
        return $new;
    }

    /**
     * Set container tag ID.
     *
     * @param string|null $id Container tag ID.
     */
    final public function containerId(?string $id): static
    {
        $new = clone $this;
        $new->containerAttributes['id'] = $id;
        return $new;
    }

    /**
     * Replace container tag CSS classes with a new set of classes.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    final public function containerClass(?string ...$class): static
    {
        $new = clone $this;
        $new->containerAttributes['class'] = array_filter($class, static fn($c) => $c !== null);
        return $new;
    }

    /**
     * Add one or more CSS classes to the container tag.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    final public function addContainerClass(?string ...$class): static
    {
        $new = clone $this;
        Html::addCssClass($new->containerAttributes, $class);
        return $new;
    }

    final public function useContainer(bool $use): static
    {
        $new = clone $this;
        $new->useContainer = $use;
        return $new;
    }

    final public function begin(): ?string
    {
        parent::begin();
        $this->isStartedByBegin = true;

        $this->beforeRender();

        $content = $this->generateBeginContent();

        return $this->renderOpenContainerAndContent($content);
    }

    final public function render(): string
    {
        if ($this->isStartedByBegin) {
            $this->isStartedByBegin = false;
            return $this->renderEnd();
        }

        $this->beforeRender();

        $content = $this->generateContent();
        if ($content === null) {
            $this->enrichment = [];
            return '';
        }

        $result = $this->renderOpenContainerAndContent($content);

        if ($this->useContainer) {
            $result .= "\n" . Html::closeTag($this->containerTag);
        }

        $this->enrichment = [];
        return $result;
    }

    protected function beforeRender(): void {}

    abstract protected function generateContent(): ?string;

    protected function generateBeginContent(): string
    {
        return '';
    }

    protected function generateEndContent(): string
    {
        return '';
    }

    protected function prepareContainerAttributes(array &$attributes): void {}

    final protected static function getThemeConfig(?string $theme): array
    {
        return ThemeContainer::getTheme($theme)?->getFieldConfig(static::class) ?? [];
    }

    private function renderEnd(): string
    {
        $content = $this->generateEndContent();

        if (!$this->useContainer) {
            return $content;
        }

        $containerTag = CustomTag::name($this->containerTag);

        return ($content !== '' ? $content . "\n" : '') . $containerTag->close();
    }

    private function renderOpenContainerAndContent(string $content): string
    {
        if (!$this->useContainer) {
            return $content;
        }

        $containerTag = CustomTag::name($this->containerTag);

        $attributes = $this->containerAttributes;
        $this->prepareContainerAttributes($attributes);
        if ($attributes !== []) {
            $containerTag = $containerTag->addAttributes($attributes);
        }

        return $containerTag->open()
            . ($content === '' ? '' : ("\n" . $content));
    }
}
