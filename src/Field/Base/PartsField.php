<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Field\Part\Label;

abstract class PartsField extends BaseField
{
    protected string $templateBegin = "{label}\n{input}";
    protected string $templateEnd = "{input}\n{hint}\n{error}";
    protected string $template = "{label}\n{input}\n{hint}\n{error}";
    protected ?bool $hideLabel = null;

    protected array $labelConfig = [];
    protected array $hintConfig = [];
    protected array $errorConfig = [];

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

    protected function shouldHideLabel(): bool
    {
        return false;
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

    protected function generateLabel(): string
    {
        return Label::widget($this->labelConfig)->render();
    }

    protected function generateHint(): string
    {
        return Hint::widget($this->hintConfig)->render();
    }

    protected function generateError(): string
    {
        return Error::widget($this->errorConfig)->render();
    }

    final protected function generateContent(): ?string
    {
        $parts = [
            '{input}' => $this->generateInput(),
            '{label}' => ($this->hideLabel ?? $this->shouldHideLabel()) ? '' : $this->generateLabel(),
            '{hint}' => $this->generateHint(),
            '{error}' => $this->generateError(),
        ];

        return preg_replace('/^\h*\v+/m', '', trim(strtr($this->template, $parts)));
    }

    final protected function generateBeginContent(): string
    {
        $parts = [
            '{input}' => $this->generateBeginInput(),
            '{label}' => ($this->hideLabel ?? $this->shouldHideLabel()) ? '' : $this->generateLabel(),
            '{hint}' => $this->generateHint(),
            '{error}' => $this->generateError(),
        ];

        return preg_replace('/^\h*\v+/m', '', trim(strtr($this->templateBegin, $parts)));
    }

    final protected function generateEndContent(): string
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
