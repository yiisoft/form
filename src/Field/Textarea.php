<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\EnrichmentFromRules\EnrichmentFromRulesInterface;
use Yiisoft\Form\Field\Base\EnrichmentFromRules\EnrichmentFromRulesTrait;
use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Form\Field\Base\Placeholder\PlaceholderInterface;
use Yiisoft\Form\Field\Base\Placeholder\PlaceholderTrait;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassInterface;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassTrait;
use Yiisoft\Html\Html;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\Required;

use function is_string;

/**
 * Represents `<textarea>` element that create a multi-line plain-text editing control.
 *
 * @link https://html.spec.whatwg.org/multipage/form-elements.html#the-textarea-element
 * @link https://developer.mozilla.org/docs/Web/HTML/Element/textarea
 */
final class Textarea extends InputField implements
    EnrichmentFromRulesInterface,
    PlaceholderInterface,
    ValidationClassInterface
{
    use EnrichmentFromRulesTrait;
    use PlaceholderTrait;
    use ValidationClassTrait;

    /**
     * Maximum length of value.
     *
     * @param int|null $value A limit on the number of characters a user can input.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-maxlength
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-maxlength
     */
    public function maxlength(?int $value): self
    {
        $new = clone $this;
        $new->inputAttributes['maxlength'] = $value;
        return $new;
    }

    /**
     * Minimum length of value.
     *
     * @param int|null $value A lower bound on the number of characters a user can input.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-minlength
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-minlength
     */
    public function minlength(?int $value): self
    {
        $new = clone $this;
        $new->inputAttributes['minlength'] = $value;
        return $new;
    }

    /**
     * Name of form control to use for sending the element's directionality in form submission
     *
     * @param string|null $value Any string that is not empty.
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-dirname
     */
    public function dirname(?string $value): self
    {
        $new = clone $this;
        $new->inputAttributes['dirname'] = $value;
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

    /**
     * The expected maximum number of characters per line of text to show.
     *
     * @link https://html.spec.whatwg.org/multipage/form-elements.html#attr-textarea-cols
     */
    public function cols(?int $value): self
    {
        $new = clone $this;
        $new->inputAttributes['cols'] = $value;
        return $new;
    }

    /**
     * The number of lines of text to show.
     *
     * @link https://html.spec.whatwg.org/multipage/form-elements.html#attr-textarea-rows
     */
    public function rows(?int $value): self
    {
        $new = clone $this;
        $new->inputAttributes['rows'] = $value;
        return $new;
    }

    /**
     * Define how the value of the form control is to be wrapped for form submission:
     *  - `hard` indicates that the text in the `textarea` is to have newlines added by the user agent so that the text
     *    is wrapped when it is submitted.
     *  - `soft` indicates that the text in the `textarea` is not to be wrapped when it is submitted (though it can
     *    still be wrapped in the rendering).
     *
     * @link https://html.spec.whatwg.org/multipage/form-elements.html#attr-textarea-wrap
     */
    public function wrap(?string $value): self
    {
        $new = clone $this;
        $new->inputAttributes['wrap'] = $value;
        return $new;
    }

    /**
     * @psalm-suppress MixedAssignment,MixedArgument Remove after fix https://github.com/yiisoft/validator/issues/225
     */
    protected function beforeRender(): void
    {
        parent::beforeRender();
        if ($this->enrichmentFromRules && $this->hasFormModelAndAttribute()) {
            $rules = $this
                    ->getFormModel()
                    ->getRules()[$this->getFormAttributeName()] ?? [];
            foreach ($rules as $rule) {
                if ($rule instanceof Required) {
                    $this->inputAttributes['required'] = true;
                }

                if ($rule instanceof HasLength) {
                    if (null !== $min = $rule->getOptions()['min']) {
                        $this->inputAttributes['minlength'] = $min;
                    }
                    if (null !== $max = $rule->getOptions()['max']) {
                        $this->inputAttributes['maxlength'] = $max;
                    }
                }
            }
        }
    }

    protected function generateInput(): string
    {
        $value = $this->getFormAttributeValue();

        if (!is_string($value) && $value !== null) {
            throw new InvalidArgumentException('Textarea field requires a string or null value.');
        }

        $textareaAttributes = $this->getInputAttributes();

        return Html::textarea($this->getInputName(), $value, $textareaAttributes)->render();
    }

    protected function prepareContainerAttributes(array &$attributes): void
    {
        if ($this->hasFormModelAndAttribute()) {
            $this->addValidationClassToAttributes(
                $attributes,
                $this->getFormModel(),
                $this->getFormAttributeName(),
            );
        }
    }

    protected function prepareInputAttributes(array &$attributes): void
    {
        $this->preparePlaceholderInInputAttributes($attributes);
    }
}
