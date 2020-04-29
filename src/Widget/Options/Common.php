<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Options;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Html\Html;

/**
 * Common form widget options
 */
trait Common
{
    private ?string $id = null;
    private FormModelInterface $data;
    private string $attribute;
    private array $options = [];
    private string $charset = 'UTF-8';

    public function id(?string $value): self
    {
        $new = clone $this;
        $new->id = $value;
        return $new;
    }

    public function config(FormModelInterface $data, string $attribute, array $options = []): self
    {
        $new = clone $this;
        $new->data = $data;
        $new->attribute = $attribute;
        $new->options = $options;
        return $new;
    }

    public function charset(string $value): self
    {
        $new = clone $this;
        $new->charset = $value;
        return $new;
    }

    public function addLabel(bool $value = true): self
    {
        $new = clone $this;

        if ($value) {
            $new->options['label'] = Html::encode(
                $new->data->attributeLabel(
                    Html::getAttributeName($new->attribute)
                )
            );
        }

        return $new;
    }

    public function placeholder(bool $generate = true, ?string $value = null): self
    {
        $new = clone $this;

        if ($generate) {
            $attributeName = Html::getAttributeName($new->attribute);
            $new->options['placeholder'] = $new->data->attributeLabel($attributeName);
        }

        if (!$generate && !empty($value)) {
            $new->options['placeholder'] = $value;
        }

        return $new;
    }

    private function addId(): string
    {
        $new = clone $this;

        $id = $new->options['id'] ?? $new->id;

        if ($id === null) {
            $id = HtmlForm::getInputId($new->data, $new->attribute, $new->charset);
        }

        return $id !== false ? $id : '';
    }

    private function addBooleanValue(): bool
    {
        $new = clone $this;
        $value = HtmlForm::getAttributeValue($new->data, $new->attribute);

        if (!array_key_exists('value', $new->options)) {
            $new->options['value'] = '1';
        }

        return (bool) $value;
    }

    private function addHint(): string
    {
        $new = clone $this;
        return $new->options['hint'] ?? $new->data->attributeHint($new->attribute);
    }

    private function addName(): string
    {
        $new = clone $this;
        $name = $new->options['name'] ?? HtmlForm::getInputName($new->data, $new->attribute);

        return ArrayHelper::remove($this->options, 'name', $name);
    }

    private function asStringLabel(): string
    {
        $new = clone $this;

        return ArrayHelper::remove(
            $this->options,
            'label',
            Html::encode($new->data->attributeLabel($new->attribute))
        );
    }

    private function asStringFor(): ?string
    {
        $new = clone $this;

        return ArrayHelper::remove(
            $this->options,
            'for',
            HtmlForm::getInputId($new->data, $new->attribute, $new->charset)
        );
    }

    private function placeholderOptions(self $new): self
    {
        if (isset($new->options['placeholder']) && $new->options['placeholder'] === true) {
            $attributeName = Html::getAttributeName($new->attribute);
            $new->options['placeholder'] = $new->data->attributeLabel($attributeName);
        }

        return $new;
    }

    private function addValue()
    {
        $new = clone $this;

        $value = HtmlForm::getAttributeValue($new->data, $new->attribute);
        if ($value !== null && is_scalar($value)) {
            $value = (string)$value;
        }

        return ArrayHelper::remove(
            $this->options,
            'value',
            $value
        );
    }
}
