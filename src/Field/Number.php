<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Form\Field\Base\EnrichFromValidationRules\EnrichFromValidationRulesInterface;
use Yiisoft\Form\Field\Base\EnrichFromValidationRules\EnrichFromValidationRulesTrait;
use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Form\Field\Base\Placeholder\PlaceholderInterface;
use Yiisoft\Form\Field\Base\Placeholder\PlaceholderTrait;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassInterface;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassTrait;
use Yiisoft\Html\Html;

/**
 * Represents `<input>` element of type "number" are used to let the user enter and edit a telephone number.
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#number-state-(type=number)
 * @link https://developer.mozilla.org/docs/Web/HTML/Element/input/number
 */
final class Number extends InputField implements EnrichFromValidationRulesInterface, PlaceholderInterface, ValidationClassInterface
{
    use EnrichFromValidationRulesTrait;
    use PlaceholderTrait;
    use ValidationClassTrait;

    /**
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-max
     */
    public function max(int|float|string|Stringable|null $value): self
    {
        $new = clone $this;
        $new->inputAttributes['max'] = $value;
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-min
     */
    public function min(int|float|string|Stringable|null $value): self
    {
        $new = clone $this;
        $new->inputAttributes['min'] = $value;
        return $new;
    }

    /**
     * Granularity to be matched by the form control's value.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-step
     */
    public function step(float|int|string|Stringable|null $value): self
    {
        $new = clone $this;
        $new->inputAttributes['step'] = $value;
        return $new;
    }

    /**
     * A boolean attribute that controls whether or not the user can edit the form control.
     *
     * @param bool $value Whether to allow the value to be edited by the user.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-readonly
     */
    public function readonly(bool $value = true): self
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
    public function required(bool $value = true): self
    {
        $new = clone $this;
        $new->inputAttributes['required'] = $value;
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
     * Identifies the element (or elements) that describes the object.
     *
     * @link https://w3c.github.io/aria/#aria-describedby
     */
    public function ariaDescribedBy(?string $value): self
    {
        $new = clone $this;
        $new->inputAttributes['aria-describedby'] = $value;
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

    protected function beforeRender(): void
    {
        if ($this->enrichFromValidationRules) {
            $this->enrichment = $this
                ->validationRulesEnricher
                ?->process($this, $this->getInputData()->getValidationRules())
                ?? [];
        }
    }

    protected function generateInput(): string
    {
        $value = $this->getValue();

        if (!is_numeric($value) && $value !== null) {
            throw new InvalidArgumentException('Number field requires a numeric or null value.');
        }

        /** @psalm-suppress MixedArgument We guess that enrichment contain correct values. */
        $inputAttributes = array_merge(
            $this->enrichment['inputAttributes'] ?? [],
            $this->getInputAttributes()
        );

        return Html::input('number', $this->getName(), $value, $inputAttributes)->render();
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
        $this->preparePlaceholderInInputAttributes($attributes);
        $this->addInputValidationClassToAttributes(
            $attributes,
            $this->getInputData(),
            $this->hasCustomError() ? true : null,
        );
    }
}
