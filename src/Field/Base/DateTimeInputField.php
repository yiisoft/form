<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use DateTimeInterface;
use InvalidArgumentException;
use ReflectionClass;
use Yiisoft\Form\Field\Base\EnrichFromValidationRules\EnrichFromValidationRulesInterface;
use Yiisoft\Form\Field\Base\EnrichFromValidationRules\EnrichFromValidationRulesTrait;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassInterface;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassTrait;
use Yiisoft\Html\Html;

use function is_string;

abstract class DateTimeInputField extends InputField implements EnrichFromValidationRulesInterface, ValidationClassInterface
{
    use EnrichFromValidationRulesTrait;
    use ValidationClassTrait;

    /**
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-max
     */
    final public function max(?string $value): static
    {
        $new = clone $this;
        $new->inputAttributes['max'] = $value;
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-min
     */
    final public function min(?string $value): static
    {
        $new = clone $this;
        $new->inputAttributes['min'] = $value;
        return $new;
    }

    /**
     * Identifies the element (or elements) that describes the object.
     *
     * @link https://w3c.github.io/aria/#aria-describedby
     */
    final public function ariaDescribedBy(?string ...$value): static
    {
        $new = clone $this;
        $new->inputAttributes['aria-describedby'] = array_filter($value, static fn(?string $v): bool => $v !== null);
        return $new;
    }

    /**
     * Defines a string value that labels the current element.
     *
     * @link https://w3c.github.io/aria/#aria-label
     */
    final public function ariaLabel(?string $value): static
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
    final public function autofocus(bool $value = true): static
    {
        $new = clone $this;
        $new->inputAttributes['autofocus'] = $value;
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
        $new->inputAttributes['tabindex'] = $value;
        return $new;
    }

    /**
     * A boolean attribute that controls whether the user can edit the form control.
     *
     * @param bool $value Whether to allow the value to be edited by the user.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-readonly
     */
    final public function readonly(bool $value = true): static
    {
        $new = clone $this;
        $new->inputAttributes['readonly'] = $value;
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
        $new->inputAttributes['required'] = $value;
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-disabled
     */
    final public function disabled(bool $disabled = true): static
    {
        $new = clone $this;
        $new->inputAttributes['disabled'] = $disabled;
        return $new;
    }

    protected function beforeRender(): void
    {
        if ($this->enrichFromValidationRules) {
            $this->enrichment = $this
                ->validationRulesEnricher
                ?->process($this, $this->getInputData()->getValidationRules())
                ?? [];
        }
    }

    final protected function generateInput(): string
    {
        $value = $this->getValue();

        if ($value instanceof DateTimeInterface) {
            $value = $this->formatDateTime($value);
        } elseif (!is_string($value) && $value !== null) {
            throw new InvalidArgumentException(
                (new ReflectionClass($this))->getShortName()
                . ' field requires a string or null value.',
            );
        }

        /** @psalm-suppress MixedArgument We guess that enrichment contain correct values. */
        $inputAttributes = array_merge(
            $this->enrichment['inputAttributes'] ?? [],
            $this->getInputAttributes(),
        );

        return Html::input($this->getInputType(), $this->getName(), $value, $inputAttributes)->render();
    }

    abstract protected function formatDateTime(DateTimeInterface $value): string;

    abstract protected function getInputType(): string;

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
}
