<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Yiisoft\Html\Tag\Label;

final class FieldFactoryConfig
{
    private ?string $template = null;

    private ?bool $setInputIdAttribute = null;

    private ?Label $labelTag = null;
    private ?bool $setLabelForAttribute = null;

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

    public function labelTag(?Label $tag): self
    {
        $new = clone $this;
        $new->labelTag = $tag;
        return $new;
    }

    public function setLabelForAttribute(?bool $value): self
    {
        $new = clone $this;
        $new->setLabelForAttribute = $value;
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

    public function getLabelTag(): ?Label
    {
        return $this->labelTag;
    }

    public function getSetLabelForAttribute(): ?bool
    {
        return $this->setLabelForAttribute;
    }

    public function getInputTextConfig(): array
    {
        return $this->inputTextConfig;
    }
}
