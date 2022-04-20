<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Html\Html;

use function is_bool;
use function is_object;
use function is_string;

/**
 * The input element with a type attribute whose value is "checkbox" represents a state or option that can be toggled.
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#checkbox-state-(type=checkbox)
 */
final class Checkbox extends InputField
{
    private ?string $uncheckValue = '0';
    private bool $enclosedByLabel = true;
    private ?string $inputLabel = null;
    private array $inputLabelAttributes = [];
    private bool $inputLabelEncode = true;
    private ?string $inputValue = null;

    /**
     * @param bool|float|int|string|Stringable|null $value Value that corresponds to "unchecked" state of the input.
     */
    public function uncheckValue(bool|float|int|string|Stringable|null $value): self
    {
        $new = clone $this;
        $new->uncheckValue = $this->prepareValue($value);
        return $new;
    }

    /**
     * If the input should be enclosed by label.
     *
     * @param bool $value If the input should be en closed by label.
     */
    public function enclosedByLabel(bool $value): self
    {
        $new = clone $this;
        $new->enclosedByLabel = $value;
        return $new;
    }

    /**
     * Label displayed next to the checkbox.
     *
     * When this option is specified, the checkbox will be enclosed by a label tag.
     *
     * @param string|null $value
     *
     * @return self
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#the-label-element
     */
    public function inputLabel(?string $value): self
    {
        $new = clone $this;
        $new->inputLabel = $value;
        return $new;
    }

    /**
     * HTML attributes for the label tag.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function inputLabelAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->inputLabelAttributes = $attributes;
        return $new;
    }

    public function inputLabelEncode(bool $encode): self
    {
        $new = clone $this;
        $new->inputLabelEncode = $encode;
        return $new;
    }

    public function inputValue(bool|float|int|string|Stringable|null $value): self
    {
        $new = clone $this;
        $new->inputValue = $this->prepareValue($value);
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-disabled
     */
    public function disabled(bool $disabled = true): self
    {
        $new = clone $this;
        $new->inputTagAttributes['disabled'] = $disabled;
        return $new;
    }

    protected function generateInput(): string
    {
        $value = $this->getAttributeValue();

        if (!is_bool($value)
            && !is_string($value)
            && !is_numeric($value)
            && $value !== null
            && (!is_object($value) || !method_exists($value, '__toString'))
        ) {
            throw new InvalidArgumentException(
                'Checkbox widget requires a string, numeric, bool, Stringable or null value.'
            );
        }

        $value = $this->prepareValue($value);

        $tagAttributes = $this->getInputTagAttributes();

        $inputValue = $this->inputValue;
        $inputValue = $inputValue ?? $this->prepareValue($tagAttributes['value'] ?? null);
        unset($tagAttributes['value']);
        $inputValue = $inputValue ?? '1';

        $checkbox = Html::checkbox($this->getInputName(), $inputValue, $tagAttributes);

        $label = $this->inputLabel ?? $this->getAttributeLabel();

        if ($this->enclosedByLabel) {
            $checkbox = $checkbox
                ->label($label, $this->inputLabelAttributes)
                ->labelEncode($this->inputLabelEncode);
        }

        $html = $checkbox
            ->checked($inputValue === $value)
            ->uncheckValue($this->uncheckValue)
            ->render();

        if (!$this->enclosedByLabel && $this->inputLabel !== null) {
            $html .= ' ' . ($this->inputLabelEncode ? Html::encode($this->inputLabel) : $this->inputLabel);
        }

        return $html;
    }

    protected function shouldHideLabel(): bool
    {
        return $this->enclosedByLabel;
    }

    private function prepareValue(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        return (string) $value;
    }
}
