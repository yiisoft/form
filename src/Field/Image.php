<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Stringable;
use Yiisoft\Form\Field\Base\PartsField;
use Yiisoft\Html\Html;

/**
 * Represents `<input>` element of type "image" are used to create graphical submit buttons.
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#image-button-state-(type=image)
 * @link https://developer.mozilla.org/docs/Web/HTML/Element/input/image
 */
final class Image extends PartsField
{
    private array $inputAttributes = [];

    /**
     * Provides the textual label for the button for users and user agents who cannot use the image.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-alt
     */
    public function alt(?string $value): self
    {
        $new = clone $this;
        $new->inputAttributes['alt'] = $value;
        return $new;
    }

    public function width(int|string|Stringable|null $width): self
    {
        $new = clone $this;
        $new->inputAttributes['width'] = $width;
        return $new;
    }

    public function height(int|string|Stringable|null $height): self
    {
        $new = clone $this;
        $new->inputAttributes['height'] = $height;
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-src
     */
    public function src(?string $url): self
    {
        $new = clone $this;
        $new->inputAttributes['src'] = $url;
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
     * Identifies the element (or elements) that describes the object.
     *
     * @link https://w3c.github.io/aria/#aria-describedby
     */
    public function ariaDescribedBy(?string ...$value): self
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
    public function ariaLabel(?string $value): self
    {
        $new = clone $this;
        $new->inputAttributes['aria-label'] = $value;
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

    public function inputAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->inputAttributes = $attributes;
        return $new;
    }

    public function addInputAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->inputAttributes = array_merge($new->inputAttributes, $attributes);
        return $new;
    }

    protected function generateInput(): string
    {
        return Html::input(
            type: 'image',
            attributes: $this->inputAttributes,
        )->render();
    }
}
