<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassInterface;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassTrait;
use Yiisoft\Html\Html;

use function is_bool;
use function is_string;

/**
 * The input element with a type attribute whose value is "checkbox" represents a state or option that can be toggled.
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#checkbox-state-(type=checkbox)
 * @link https://developer.mozilla.org/docs/Web/HTML/Element/input/checkbox
 */
final class Checkbox extends InputField implements ValidationClassInterface
{
    use ValidationClassTrait;

    private ?string $uncheckValue = '0';
    private bool $enclosedByLabel = true;
    private CheckboxLabelPlacement $labelPlacement = CheckboxLabelPlacement::WRAP;
    private ?string $inputLabel = null;
    private array $inputLabelAttributes = [];
    private bool $inputLabelEncode = true;
    private ?string $inputValue = null;

    /**
     * Identifies the element (or elements) that describes the object.
     *
     * @link https://w3c.github.io/aria/#aria-describedby
     */
    public function ariaDescribedBy(?string ...$value): self
    {
        $new = clone $this;
        $new->inputAttributes['aria-describedby'] = array_filter($value, static fn (?string $v): bool => $v !== null);
        return $new;
    }

    /**
     * Defines a string value that labels the current element.
     *
     * @link https://w3c.github.io/aria/#aria-label
     */
    public function ariaLabel(?string $value): self
    {
        $new = clone $this;
        $new->inputAttributes['aria-label'] = $value;
        return $new;
    }

    /**
     * Focus on the control (put cursor into it) when the page loads. Only one form element could be in focus
     * at the same time.
     *
     * @link https://html.spec.whatwg.org/multipage/interaction.html#attr-fe-autofocus
     */
    public function autofocus(bool $value = true): self
    {
        $new = clone $this;
        $new->inputAttributes['autofocus'] = $value;
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-disabled
     */
    public function disabled(bool $disabled = true): self
    {
        $new = clone $this;
        $new->inputAttributes['disabled'] = $disabled;
        return $new;
    }

    /**
     * If the input should be enclosed by label.
     *
     * @param bool $value If the input should be en closed by label.
     *
     * @deprecated Use {@see labelPLacement()} instead it.
     */
    public function enclosedByLabel(bool $value): self
    {
        $new = clone $this;
        $new->enclosedByLabel = $value;
        return $new;
    }

    /**
     * Set label placement relative to checkbox input.
     *
     * @see CheckboxLabelPlacement
     */
    public function labelPlacement(CheckboxLabelPlacement $placement): self
    {
        $new = clone $this;
        $new->labelPlacement = $placement;
        return $new;
    }

    /**
     * Label displayed next to the checkbox.
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

    public function addInputLabelAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->inputLabelAttributes = array_merge($new->inputLabelAttributes, $attributes);
        return $new;
    }

    /**
     * Set checkbox label tag ID.
     *
     * @param string|null $id Label tag ID.
     */
    public function inputLabelId(?string $id): self
    {
        $new = clone $this;
        $new->inputLabelAttributes['id'] = $id;
        return $new;
    }

    /**
     * Replace checkbox label tag CSS classes with a new set of classes.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    public function inputLabelClass(?string ...$class): self
    {
        $new = clone $this;
        $new->inputLabelAttributes['class'] = array_filter($class, static fn ($c) => $c !== null);
        return $new;
    }

    /**
     * Add one or more CSS classes to the checkbox label tag.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    public function addInputLabelClass(?string ...$class): self
    {
        $new = clone $this;
        Html::addCssClass($new->inputLabelAttributes, $class);
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
        $new->inputValue = $this->prepareCheckboxValue($value);
        return $new;
    }

    /**
     * The `tabindex` attribute indicates that its element can be focused, and where it participates in sequential
     * keyboard navigation (usually with the Tab key, hence the name).
     *
     * It accepts an integer as a value, with different results depending on the integer's value:
     *
     * - A negative value (usually `tabindex="-1"`) means that the element is not reachable via sequential keyboard
     *   navigation, but could be focused with Javascript or visually. It's mostly useful to create accessible widgets
     *   with JavaScript.
     * - `tabindex="0"` means that the element should be focusable in sequential keyboard navigation, but its order is
     *   defined by the document's source order.
     * - A positive value means the element should be focusable in sequential keyboard navigation, with its order
     *   defined by the value of the number. That is, `tabindex="4"` is focused before `tabindex="5"`, but after
     *   `tabindex="3"`.
     *
     * @link https://html.spec.whatwg.org/multipage/interaction.html#attr-tabindex
     */
    public function tabIndex(?int $value): self
    {
        $new = clone $this;
        $new->inputAttributes['tabindex'] = $value;
        return $new;
    }

    /**
     * @param bool|float|int|string|Stringable|null $value Value that corresponds to "unchecked" state of the input.
     */
    public function uncheckValue(bool|float|int|string|Stringable|null $value): self
    {
        $new = clone $this;
        $new->uncheckValue = $this->prepareCheckboxValue($value);
        return $new;
    }

    protected function generateInput(): string
    {
        $value = $this->getValue();
        if (
            !is_bool($value)
            && !is_string($value)
            && !$value instanceof Stringable
            && !is_numeric($value)
            && $value !== null
        ) {
            throw new InvalidArgumentException(
                'Checkbox widget requires a string, Stringable, numeric, bool or null value.'
            );
        }

        $value = $this->prepareCheckboxValue($value);

        $inputAttributes = $this->getInputAttributes();

        $inputValue = $this->inputValue;
        $inputValue ??= $this->prepareCheckboxValue($inputAttributes['value'] ?? null);
        unset($inputAttributes['value']);
        $inputValue ??= '1';

        $checkbox = Html::checkbox($this->getName(), $inputValue, $inputAttributes);

        $labelPlacement = $this->getLabelPlacement();

        if ($labelPlacement === CheckboxLabelPlacement::WRAP) {
            $label = $this->inputLabel ?? $this->label ?? $this->getInputData()->getLabel();
            $checkbox = $checkbox
                ->label($label, $this->inputLabelAttributes)
                ->labelEncode($this->inputLabelEncode);
        } elseif ($labelPlacement === CheckboxLabelPlacement::SIDE) {
            $label = $this->inputLabel ?? $this->label ?? $this->getInputData()->getLabel();
            $checkbox = $checkbox
                ->sideLabel($label, $this->inputLabelAttributes)
                ->labelEncode($this->inputLabelEncode);
        }

        $html = $checkbox
            ->checked($inputValue === $value)
            ->uncheckValue($this->uncheckValue)
            ->render();

        if ($labelPlacement === CheckboxLabelPlacement::DEFAULT && $this->inputLabel !== null) {
            $html .= ' ' . ($this->inputLabelEncode ? Html::encode($this->inputLabel) : $this->inputLabel);
        }

        return $html;
    }

    protected function shouldHideLabel(): bool
    {
        return $this->getLabelPlacement() !== CheckboxLabelPlacement::DEFAULT;
    }

    private function prepareCheckboxValue(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        return (string) $value;
    }

    protected function prepareContainerAttributes(array &$attributes): void
    {
        $this->addValidationClassToAttributes(
            $attributes,
            $this->getInputData(),
            $this->hasCustomError() ? true : null,
        );
    }

    protected function prepareInputAttributes(array &$attributes): void
    {
        $this->addInputValidationClassToAttributes(
            $attributes,
            $this->getInputData(),
            $this->hasCustomError() ? true : null,
        );
    }

    private function getLabelPlacement(): CheckboxLabelPlacement
    {
        // If default value, use deprecated `enclosedByLabel` property
        if ($this->labelPlacement === CheckboxLabelPlacement::WRAP) {
            return $this->enclosedByLabel ? CheckboxLabelPlacement::WRAP : CheckboxLabelPlacement::DEFAULT;
        }

        return $this->labelPlacement;
    }
}
