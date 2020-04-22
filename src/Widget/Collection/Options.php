<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Collection;

use Yiisoft\Form\FormInterface;

trait Options
{
    private ?string $id = null;
    private FormInterface $data;
    private string $attribute;
    private array $options = [];
    private string $charset = 'UTF-8';
    private ?string $type = null;

    /**
     * Set the Id of the widget.
     *
     * @param string|null $value
     *
     * @return self Id of the widget.
     */
    public function id(?string $value): self
    {
        $immutable = clone $this;
        $immutable->id = $value;
        return $immutable;
    }

    /**
     * Form structure data entry of the widget.
     *
     * @param FormInterface $value
     *
     * @return self
     */
    public function data(FormInterface $value): self
    {
        $immutable = clone $this;
        $immutable->data = $value;
        return $immutable;
    }

    /**
     * The attribute name or expression.
     *
     * @param string $value
     *
     * @return self
     *
     * {@see \Yiisoft\Html\FormHTml::getAttributeName()} for the format about attribute expression.
     */
    public function attribute(string $value): self
    {
        $immutable = clone $this;
        $immutable->attribute = $value;
        return $immutable;
    }

    public function charset(string $value): self
    {
        $immutable = clone $this;
        $immutable->charset = $value;
        return $immutable;
    }

    public function type(string $value): self
    {
        $immutable = clone $this;
        $immutable->type = $value;
        return $immutable;
    }

    /**
     * The HTML attributes for the widget container tag. The following special options are recognized.
     *
     * @param array $value
     *
     * @return self
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function options(array $value): self
    {
        $immutable = clone $this;
        $immutable->options = $value;
        return $immutable;
    }

    private function addId(): void
    {
        $this->options['id'] = $this->options['id'] ?? $this->id;

        if ($this->options['id'] === null) {
            $this->options['id'] = $this->addInputId($this->data, $this->attribute, $this->charset);
        }
    }

    private function addHint(): string
    {
        return $this->options['hint'] ?? $this->data->attributeHint($this->attribute);
    }

    private function addName(): string
    {
        return $this->options['name'] ?? $this->getInputName($this->data, $this->attribute);
    }

    private function addSelection(): string
    {
        return $this->options['name'] ?? $this->getInputName($this->data, $this->attribute);
    }
}
