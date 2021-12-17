<?php

declare(strict_types=1);

namespace Yiisoft\Form;

final class FieldFactoryConfig
{
    private ?string $template = null;

    private ?bool $setInputIdAttribute = null;

    private array $labelConfig = [];
    private array $hintConfig = [];
    private array $errorConfig = [];

    private array $inputTextConfig = [];

    public function template(?string $template): self
    {
        $new = clone $this;
        $new->template = $template;
        return $new;
    }

    public function setInputIdAttribute(?bool $value): self
    {
        $new = clone $this;
        $new->setInputIdAttribute = $value;
        return $new;
    }

    public function labelConfig(array $config): self
    {
        $new = clone $this;
        $new->labelConfig = $config;
        return $new;
    }

    public function hintConfig(array $config): self
    {
        $new = clone $this;
        $new->hintConfig = $config;
        return $new;
    }

    public function errorConfig(array $config): self
    {
        $new = clone $this;
        $new->errorConfig = $config;
        return $new;
    }

    public function inputTextConfig(array $config): self
    {
        $new = clone $this;
        $new->inputTextConfig = $config;
        return $new;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function getSetInputIdAttribute(): ?bool
    {
        return $this->setInputIdAttribute;
    }

    public function getLabelConfig(): array
    {
        return $this->labelConfig;
    }

    public function getHintConfig(): array
    {
        return $this->hintConfig;
    }

    public function getErrorConfig(): array
    {
        return $this->errorConfig;
    }

    public function getInputTextConfig(): array
    {
        return $this->inputTextConfig;
    }
}
