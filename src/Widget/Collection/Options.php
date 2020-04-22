<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Collection;

use Yiisoft\Form\FormInterface;
use Yiisoft\Form\Helper\HtmlForm;

trait Options
{
    private ?string $id = null;
    private FormInterface $data;
    private string $attribute;
    private array $options = [];
    private string $charset = 'UTF-8';
    private ?string $type = null;

    public function id(?string $value): self
    {
        $new = clone $this;
        $new->id = $value;
        return $new;
    }

    public function data(FormInterface $value): self
    {
        $new = clone $this;
        $new->data = $value;
        return $new;
    }

    public function attribute(string $value): self
    {
        $new = clone $this;
        $new->attribute = $value;
        return $new;
    }

    public function charset(string $value): self
    {
        $new = clone $this;
        $new->charset = $value;
        return $new;
    }

    public function type(string $value): self
    {
        $new = clone $this;
        $new->type = $value;
        return $new;
    }

    public function options(array $value): self
    {
        $new = clone $this;
        $new->options = $value;
        return $new;
    }

    private function addId(): void
    {
        $this->options['id'] = $this->options['id'] ?? $this->id;

        if ($this->options['id'] === null) {
            $this->options['id'] = HtmlForm::getInputId($this->data, $this->attribute, $this->charset);
        }
    }

    private function addHint(): string
    {
        return $this->options['hint'] ?? $this->data->attributeHint($this->attribute);
    }

    private function addName(): string
    {
        return $this->options['name'] ?? HtmlForm::getInputName($this->data, $this->attribute);
    }
}
