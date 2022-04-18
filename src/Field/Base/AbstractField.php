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

    protected string $templateBegin = "{label}\n{input}";
    protected string $templateEnd = "{input}\n{hint}\n{error}";
    protected string $template = "{label}\n{input}\n{hint}\n{error}";
    protected ?bool $hideLabel = null;

    protected array $labelConfig = [];
    protected array $hintConfig = [];
    protected array $errorConfig = [];

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

    /**
     * Set layout template for render a field.
     */
    final public function template(string $template): static
    {
        $new = clone $this;
        $new->template = $template;
        return $new;
    }

    final public function hideLabel(?bool $hide = true): static
    {
        $new = clone $this;
        $new->hideLabel = $hide;
        return $new;
    }

    final public function labelConfig(array $config): static
    {
        $new = clone $this;
        $new->labelConfig = $config;
        return $new;
    }

    final public function label(?string $content): static
    {
        $new = clone $this;
        $new->labelConfig['content()'] = [$content];
        return $new;
    }

    final public function hintConfig(array $config): static
    {
        $new = clone $this;
        $new->hintConfig = $config;
        return $new;
    }

    final public function hint(?string $content): static
    {
        $new = clone $this;
        $new->hintConfig['content()'] = [$content];
        return $new;
    }

    final public function errorConfig(array $config): static
    {
        $new = clone $this;
        $new->errorConfig = $config;
        return $new;
    }

    final public function error(?string $message): static
    {
        $new = clone $this;
        $new->errorConfig['message()'] = [$message];
        return $new;
    }

    final public function begin(): ?string
    {
        parent::begin();
        $this->isStartedByBegin = true;

        $content = $this->generateBeginContent();

        if (!$this->useContainer) {
            return $content;
        }

        $containerTag = CustomTag::name($this->containerTag);
        if ($this->containerTagAttributes !== []) {
            $containerTag = $containerTag->attributes($this->containerTagAttributes);
        }

        return $containerTag->open()
            . ($content === '' ? '' : (PHP_EOL . $content))
            . PHP_EOL;
    }

    final protected function run(): string
    {
        if ($this->isStartedByBegin) {
            $this->isStartedByBegin = false;
            return $this->renderEnd();
        }

        $content = $this->generateContent();

        if (!$this->useContainer) {
            return $content;
        }

        $containerTag = CustomTag::name($this->containerTag);
        if ($this->containerTagAttributes !== []) {
            $containerTag = $containerTag->attributes($this->containerTagAttributes);
        }

        return $containerTag->open()
            . ($content === '' ? '' : (PHP_EOL . $content))
            . PHP_EOL
            . $containerTag->close();
    }

    protected function shouldHideLabel(): bool
    {
        return false;
    }

    private function renderEnd(): string
    {
        $content = $this->generateEndContent();

        if (!$this->useContainer) {
            return $content;
        }

        $containerTag = CustomTag::name($this->containerTag);

        return
            "\n" .
            ($content !== '' ? $content . "\n" : '')
            . $containerTag->close();
    }

    protected function generateInput(): string
    {
        return '';
    }

    protected function generateBeginInput(): string
    {
        return '';
    }

    protected function generateEndInput(): string
    {
        return '';
    }

    abstract protected function generateLabel(): string;

    abstract protected function generateHint(): string;

    abstract protected function generateError(): string;

    private function generateContent(): string
    {
        $parts = [
            '{input}' => $this->generateInput(),
            '{label}' => ($this->hideLabel ?? $this->shouldHideLabel()) ? '' : $this->generateLabel(),
            '{hint}' => $this->generateHint(),
            '{error}' => $this->generateError(),
        ];

        return preg_replace('/^\h*\v+/m', '', trim(strtr($this->template, $parts)));
    }

    private function generateBeginContent(): string
    {
        $parts = [
            '{input}' => $this->generateBeginInput(),
            '{label}' => ($this->hideLabel ?? $this->shouldHideLabel()) ? '' : $this->generateLabel(),
            '{hint}' => $this->generateHint(),
            '{error}' => $this->generateError(),
        ];

        return preg_replace('/^\h*\v+/m', '', trim(strtr($this->templateBegin, $parts)));
    }

    private function generateEndContent(): string
    {
        $parts = [
            '{input}' => $this->generateEndInput(),
            '{label}' => ($this->hideLabel ?? $this->shouldHideLabel()) ? '' : $this->generateLabel(),
            '{hint}' => $this->generateHint(),
            '{error}' => $this->generateError(),
        ];

        return preg_replace('/^\h*\v+/m', '', trim(strtr($this->templateEnd, $parts)));
    }
}
