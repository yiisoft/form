<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Stringable;
use Yiisoft\Form\Field\Base\EnrichFromValidationRules\EnrichFromValidationRulesInterface;
use Yiisoft\Form\Field\Base\EnrichFromValidationRules\EnrichFromValidationRulesTrait;
use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassInterface;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassTrait;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Html\Html;

/**
 * Represents `<input>` element of type "file" are ley the user choose one or more files from their device storage.
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#file-upload-state-(type=file)
 * @link https://developer.mozilla.org/docs/Web/HTML/Element/input/file
 */
final class File extends InputField implements EnrichFromValidationRulesInterface, ValidationClassInterface
{
    use EnrichFromValidationRulesTrait;
    use ValidationClassTrait;

    private bool|float|int|string|Stringable|null $uncheckValue = null;
    private array $uncheckInputAttributes = [];

    /**
     * The accept attribute value is a string that defines the file types the file input should accept. This string is
     * a comma-separated list of unique file type specifiers. Because a given file type may be identified in more than
     * one manner, it's useful to provide a thorough set of type specifiers when you need files of a given format.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-accept
     */
    public function accept(?string $value): self
    {
        $new = clone $this;
        $new->inputAttributes['accept'] = $value;
        return $new;
    }

    /**
     * @param bool $multiple Whether to allow selecting multiple files.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-multiple
     */
    public function multiple(bool $multiple = true): self
    {
        $new = clone $this;
        $new->inputAttributes['multiple'] = $multiple;
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
     * @param bool $disabled Whether select input is disabled.
     *
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
        $new->uncheckValue = $value;
        return $new;
    }

    public function uncheckInputAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->uncheckInputAttributes = $attributes;
        return $new;
    }

    public function addUncheckInputAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->uncheckInputAttributes = array_merge($new->uncheckInputAttributes, $attributes);
        return $new;
    }

    protected function beforeRender(): void
    {
        if ($this->enrichFromValidationRules) {
            $this->enrichment = ThemeContainer::getEnrichment($this, $this->getInputData());
        }
    }

    protected function generateInput(): string
    {
        /** @psalm-suppress MixedArgument We guess that enrichment contain correct values. */
        $inputAttributes = array_merge(
            $this->enrichment['inputAttributes'] ?? [],
            $this->getInputAttributes()
        );

        $tag = Html::file($this->getName(), attributes: $inputAttributes);
        if ($this->uncheckValue !== null) {
            $tag = $tag->uncheckValue($this->uncheckValue);
            if (!empty($this->uncheckInputAttributes)) {
                $tag = $tag->addUncheckInputAttributes($this->uncheckInputAttributes);
            }
        }

        return $tag->render();
    }

    protected function prepareContainerAttributes(array &$attributes): void
    {
        $this->addValidationClassToAttributes($attributes, $this->getInputData());
    }

    protected function prepareInputAttributes(array &$attributes): void
    {
        $this->addInputValidationClassToAttributes($attributes, $this->getInputData());
    }
}
