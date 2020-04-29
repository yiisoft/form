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

    private function getId(): string
    {
        $id = $this->options['id'] ?? $this->id;

        if ($id === null) {
            $id = HtmlForm::getInputId($this->data, $this->attribute, $this->charset);
        }

        return $id !== false ? $id : '';
    }

    private function getBooleanValueAndAddItToOptions(): bool
    {
        $value = HtmlForm::getAttributeValue($this->data, $this->attribute);

        if (!array_key_exists('value', $this->options)) {
            $this->options['value'] = '1';
        }

        return (bool) $value;
    }

    private function getNameAndRemoveItFromOptions(): string
    {
        return ArrayHelper::remove($this->options, 'name', HtmlForm::getInputName($this->data, $this->attribute));
    }

    private function setPlaceholderOptions(): void
    {
        if (isset($this->options['placeholder']) && $this->options['placeholder'] === true) {
            $attributeName = Html::getAttributeName($this->attribute);
            $this->options['placeholder'] = $this->data->attributeLabel($attributeName);
        }
    }

    private function getValueAndRemoveItFromOptions()
    {
        $value = HtmlForm::getAttributeValue($this->data, $this->attribute);
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
