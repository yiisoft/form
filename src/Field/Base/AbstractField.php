<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use InvalidArgumentException;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Widget\Widget;

abstract class AbstractField extends Widget
{
    /**
     * @psalm-var non-empty-string
     */
    protected string $containerTag = 'div';
    protected array $containerTagAttributes = [];
    protected bool $useContainer = true;

    final public function containerTag(string $tag): static
    {
        if ($tag === '') {
            throw new InvalidArgumentException('Tag name cannot be empty.');
        }

        $new = clone $this;
        $new->containerTag = $tag;
        return $new;
    }

    final public function containerTagAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->containerTagAttributes = $attributes;
        return $new;
    }

    final public function useContainer(bool $use): static
    {
        $new = clone $this;
        $new->useContainer = $use;
        return $new;
    }

    final protected function run(): string
    {
        if (!$this->useContainer) {
            return $this->generateContent();
        }

        $containerTag = CustomTag::name($this->containerTag);
        if ($this->containerTagAttributes !== []) {
            $containerTag = $containerTag->attributes($this->containerTagAttributes);
        }

        return $containerTag->open()
            . PHP_EOL
            . $this->generateContent()
            . PHP_EOL
            . $containerTag->close();
    }

    abstract protected function generateContent(): string;
}
