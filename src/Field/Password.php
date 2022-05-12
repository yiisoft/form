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
use Yiisoft\Validator\Rule\Regex;
use Yiisoft\Validator\Rule\Required;

use function is_string;

/**
 * Represents `<input>` element of type "password" are let the user securely enter a password.
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#password-state-(type=password)
 * @link https://developer.mozilla.org/docs/Web/HTML/Element/input/password
 */
final class Password extends InputField implements
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
        $new->inputTagAttributes['maxlength'] = $value;
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
        $new->inputTagAttributes['minlength'] = $value;
        return $new;
    }

    /**
     * Pattern to be matched by the form control's value.
     *
     * @param string|null $value A regular expression against which the control's value.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-pattern
     */
    public function pattern(?string $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['pattern'] = $value;
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
    public function required(bool $value = true): self
    {
        $new = clone $this;
        $new->inputTagAttributes['required'] = $value;
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

    /**
     * Identifies the element (or elements) that describes the object.
     *
     * @link https://w3c.github.io/aria/#aria-describedby
     */
    public function ariaDescribedBy(?string $value): self
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
    public function ariaLabel(?string $value): self
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
    public function autofocus(bool $value = true): self
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
    public function tabIndex(?int $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['tabindex'] = $value;
        return $new;
    }

    /**
     * The size of the control.
     *
     * @param int|null $value The number of characters that allow the user to see while editing the element's value.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-size
     */
    public function size(?int $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['size'] = $value;
        return $new;
    }

    /**
     * @psalm-suppress MixedAssignment,MixedArgument Remove after fix https://github.com/yiisoft/validator/issues/225
     */
    protected function beforeRender(): void
    {
        parent::beforeRender();
        if ($this->enrichmentFromRules && $this->hasFormModelAndAttribute()) {
            $rules = $this->getFormModel()->getRules()[$this->getAttributeName()] ?? [];
            foreach ($rules as $rule) {
                if ($rule instanceof Required) {
                    $this->inputTagAttributes['required'] = true;
                }

                if ($rule instanceof HasLength) {
                    if (null !== $min = $rule->getOptions()['min']) {
                        $this->inputTagAttributes['minlength'] = $min;
                    }
                    if (null !== $max = $rule->getOptions()['max']) {
                        $this->inputTagAttributes['maxlength'] = $max;
                    }
                }

                if ($rule instanceof Regex) {
                    if (!($rule->getOptions()['not'])) {
                        $this->inputTagAttributes['pattern'] = Html::normalizeRegexpPattern(
                            $rule->getOptions()['pattern']
                        );
                    }
                }
            }
        }
    }

    protected function generateInput(): string
    {
        $value = $this->getAttributeValue();

        if (!is_string($value) && $value !== null) {
            throw new InvalidArgumentException('Password field requires a string or null value.');
        }

        $tagAttributes = $this->getInputTagAttributes();

        return Html::passwordInput($this->getInputName(), $value, $tagAttributes)->render();
    }

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

    protected function prepareInputTagAttributes(array &$attributes): void
    {
        $this->preparePlaceholderInInputTagAttributes($attributes);
    }
}
