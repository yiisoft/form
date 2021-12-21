<?php

declare(strict_types=1);

namespace Yiisoft\Form;

final class FieldFactoryConfig
{
    //
    // Common
    //

    private ?string $containerTag = null;
    private array $containerTagAttributes = [];
    private ?bool $useContainer = null;

    private ?string $template = null;

    private ?bool $setInputIdAttribute = null;

    private array $formElementTagAttributes = [];

    private array $labelConfig = [];
    private array $hintConfig = [];
    private array $errorConfig = [];

    //
    // Placeholder
    //

    private ?bool $usePlaceholder = null;

    //
    // Field configurations
    //

    private array $fieldConfigs = [];

    public function containerTag(?string $tag): self
    {
        $new = clone $this;
        $new->containerTag = $tag;
        return $new;
    }

    public function containerTagAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->containerTagAttributes = $attributes;
        return $new;
    }

    public function useContainer(?bool $use): self
    {
        $new = clone $this;
        $new->useContainer = $use;
        return $new;
    }

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

    public function formElementTagAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->formElementTagAttributes = $attributes;
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

    public function usePlaceholder(?bool $use): self
    {
        $new = clone $this;
        $new->usePlaceholder = $use;
        return $new;
    }

    public function addFieldConfigs(array ...$configs): self
    {
        $new = clone $this;
        $new->fieldConfigs = array_merge($this->fieldConfigs, $configs);
        return $new;
    }

    public function getContainerTag(): ?string
    {
        return $this->containerTag;
    }

    public function getContainerTagAttributes(): array
    {
        return $this->containerTagAttributes;
    }

    public function getUseContainer(): ?bool
    {
        return $this->useContainer;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function getSetInputIdAttribute(): ?bool
    {
        return $this->setInputIdAttribute;
    }

    public function getFormElementTagAttributes(): array
    {
        return $this->formElementTagAttributes;
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

    public function getUsePlaceholder(): ?bool
    {
        return $this->usePlaceholder;
    }

    public function getFieldConfigs(): array
    {
        return $this->fieldConfigs;
    }
}
