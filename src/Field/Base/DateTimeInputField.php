<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use InvalidArgumentException;
use ReflectionClass;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassInterface;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassTrait;
use Yiisoft\Html\Html;

use function is_string;

abstract class DateTimeInputField extends InputField implements ValidationClassInterface
{
    use ValidationClassTrait;

    /**
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-max
     */
    final public function max(?string $value): static
    {
        $new = clone $this;
        $new->inputTagAttributes['max'] = $value;
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-min
     */
    final public function min(?string $value): static
    {
        $new = clone $this;
        $new->inputTagAttributes['min'] = $value;
        return $new;
    }

    /**
     * Identifies the element (or elements) that describes the object.
     *
     * @link https://w3c.github.io/aria/#aria-describedby
     */
    final public function ariaDescribedBy(string $value): static
    {
        $new = clone $this;
        $new->inputTagAttributes['aria-describedby'] = $value;
        return $new;
    }

    /**
     * Defines a string value that labels the current element.
     *
     * @link https://w3c.github.io/aria/#aria-label
     */
    final public function ariaLabel(string $value): static
    {
        $new = clone $this;
        $new->inputTagAttributes['aria-label'] = $value;
        return $new;
    }

    /**
     * Focus on the control (put cursor into it) when the page loads. Only one form element could be in focus
     * at the same time.
     *
     * @link https://html.spec.whatwg.org/multipage/interaction.html#attr-fe-autofocus
     */
    final public function autofocus(bool $value = true): static
    {
        $new = clone $this;
        $new->inputTagAttributes['autofocus'] = $value;
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
    final public function tabIndex(?int $value): static
    {
        $new = clone $this;
        $new->inputTagAttributes['tabindex'] = $value;
        return $new;
    }

    /**
     * A boolean attribute that controls whether or not the user can edit the form control.
     *
     * @param bool $value Whether to allow the value to be edited by the user.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-readonly
     */
    final public function readonly(bool $value = true): static
    {
        $new = clone $this;
        $new->inputTagAttributes['readonly'] = $value;
        return $new;
    }

    /**
     * A boolean attribute. When specified, the element is required.
     *
     * @param bool $value Whether the control is required for form submission.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-required
     */
    final public function required(bool $value = true): static
    {
        $new = clone $this;
        $new->inputTagAttributes['required'] = $value;
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-disabled
     */
    final public function disabled(bool $disabled = true): static
    {
        $new = clone $this;
        $new->inputTagAttributes['disabled'] = $disabled;
        return $new;
    }

    final protected function generateInput(): string
    {
        $value = $this->getAttributeValue();

        if (!is_string($value) && $value !== null) {
            throw new InvalidArgumentException(
                (new ReflectionClass($this))->getShortName() .
                ' widget must be a string or null value.'
            );
        }

        $tagAttributes = $this->getInputTagAttributes();

        return Html::input($this->getInputType(), $this->getInputName(), $value, $tagAttributes)->render();
    }

    abstract protected function getInputType(): string;

    protected function prepareContainerTagAttributes(array &$attributes): void
    {
        if ($this->hasFormModelAndAttribute()) {
            $this->addValidationClassToTagAttributes(
                $attributes,
                $this->getFormModel(),
                $this->getAttributeName(),
            );
        }
    }
}
