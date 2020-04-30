<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Widget\Widget;

final class BooleanInput extends Widget
{

    private ?string $id = null;
    private FormModelInterface $data;
    private string $attribute;
    private array $options = [];
    private string $type;
    private string $charset = 'UTF-8';

    /**
     * Generates a boolean input.
     *
     * This method is mainly called by {@see CheckboxForm} and {@see RadioForm}.
     *
     * @return string the generated input element.
     */
    public function run(): string
    {
        $new = clone $this;
        $type = $new->type;
        $new->options['form'] = $new->options['form'] ?? $new->attribute;

        if (!empty($new->getId())) {
            $new->options['id'] = $new->getId();
        }

        return Html::$type($new->getName(), $new->getBooleanValue(), $new->options);
    }

    public function config(FormModelInterface $data, string $attribute, array $options = []): self
    {
        $new = clone $this;
        $new->data = $data;
        $new->attribute = $attribute;
        $new->options = $options;
        return $new;
    }

    public function autofocus(bool $value = true): self
    {
        $new = clone $this;
        $new->options['autofocus'] = $value;
        return $new;
    }

    public function charset(string $value): self
    {
        $new = clone $this;
        $new->charset = $value;
        return $new;
    }

    public function disabled(bool $value = true): self
    {
        $new = clone $this;
        $new->options['disabled'] = $value;
        return $new;
    }

    public function form(?string $value): self
    {
        $new = clone $this;
        $new->options['form'] = $value;
        return $new;
    }

    public function id(?string $value): self
    {
        $new = clone $this;
        $new->id = $value;
        return $new;
    }

    public function label(bool $value = true): self
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

    public function labelOptions(array $value = []): self
    {
        $new = clone $this;
        $new->options['labelOptions'] = $value;
        return $new;
    }

    public function type(string $value): self
    {
        $new = clone $this;
        $new->type = $value;
        return $new;
    }

    public function uncheck(bool $value = true): self
    {
        $new = clone $this;

        if ($value) {
            $new->options['uncheck'] = '0';
        } else {
            unset($new->options['uncheck']);
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

    private function getName(): string
    {
        return ArrayHelper::remove($this->options, 'name', HtmlForm::getInputName($this->data, $this->attribute));
    }

    private function getBooleanValue(): bool
    {
        $value = HtmlForm::getAttributeValue($this->data, $this->attribute);

        if (!array_key_exists('value', $this->options)) {
            $this->options['value'] = '1';
        }

        return (bool) $value;
    }
}
