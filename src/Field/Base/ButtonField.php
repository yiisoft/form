<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;

/**
 * @link https://html.spec.whatwg.org/multipage/form-elements.html#the-button-element
 */
abstract class ButtonField extends PartsField
{
    use FieldContentTrait;

    private ?Button $button = null;
    private array $buttonAttributes = [];

    final public function button(?Button $button): static
    {
        $new = clone $this;
        $new->button = $button;
        return $new;
    }

    final public function buttonAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->buttonAttributes = array_merge($this->buttonAttributes, $attributes);
        return $new;
    }

    final public function replaceButtonAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->buttonAttributes = $attributes;
        return $new;
    }

    /**
     * Set button tag ID.
     *
     * @param string|null $id Button tag ID.
     */
    final public function buttonId(?string $id): static
    {
        $new = clone $this;
        $new->buttonAttributes['id'] = $id;
        return $new;
    }

    /**
     * Add one or more CSS classes to the button tag.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    final public function buttonClass(?string ...$class): static
    {
        $new = clone $this;
        Html::addCssClass(
            $new->buttonAttributes,
            array_filter($class, static fn ($c) => $c !== null),
        );
        return $new;
    }

    /**
     * Replace button tag CSS classes with a new set of classes.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    final public function replaceButtonClass(?string ...$class): static
    {
        $new = clone $this;
        $new->buttonAttributes['class'] = array_filter($class, static fn ($c) => $c !== null);
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-name
     */
    final public function name(?string $name): self
    {
        $new = clone $this;
        $new->buttonAttributes['name'] = $name;
        return $new;
    }

    /**
     * Identifies the element (or elements) that describes the object.
     *
     * @link https://w3c.github.io/aria/#aria-describedby
     */
    final public function ariaDescribedBy(?string $value): static
    {
        $new = clone $this;
        $new->buttonAttributes['aria-describedby'] = $value;
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
        $new->buttonAttributes['aria-label'] = $value;
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
        $new->buttonAttributes['autofocus'] = $value;
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
        $new->buttonAttributes['tabindex'] = $value;
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-disabled
     */
    final public function disabled(bool $disabled = true): static
    {
        $new = clone $this;
        $new->buttonAttributes['disabled'] = $disabled;
        return $new;
    }

    /**
     * Specifies the form element the button belongs to. The value of this attribute must be the ID attribute of a form
     * element in the same document.
     *
     * @param string|null $id ID of a form.
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fae-form
     */
    final public function form(?string $id): static
    {
        $new = clone $this;
        $new->buttonAttributes['form'] = $id;
        return $new;
    }

    final protected function generateInput(): string
    {
        $button = ($this->button ?? Button::tag())
            ->type($this->getType());

        if (!empty($this->buttonAttributes)) {
            $button = $button->attributes($this->buttonAttributes);
        }

        $content = $this->renderContent();
        if ($content !== '') {
            $button = $button->content($content);
        }

        return $button->render();
    }

    abstract protected function getType(): string;
}
