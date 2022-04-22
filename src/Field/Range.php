<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Form\Field\Base\EnrichmentFromRules\EnrichmentFromRulesInterface;
use Yiisoft\Form\Field\Base\EnrichmentFromRules\EnrichmentFromRulesTrait;
use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassInterface;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassTrait;
use Yiisoft\Html\Html;
use Yiisoft\Validator\Rule\Number as NumberRule;
use Yiisoft\Validator\Rule\Required;

use function is_string;

/**
 * An imprecise control for setting the element’s value to a string representing a number.
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#range-state-(type=range)
 */
final class Range extends InputField implements EnrichmentFromRulesInterface, ValidationClassInterface
{
    use EnrichmentFromRulesTrait;
    use ValidationClassTrait;

    private bool $showOutput = false;

    /**
     * @psalm-var non-empty-string
     */
    private string $outputTagName = 'span';
    private array $outputTagAttributes = [];

    /**
     * Maximum value.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-max
     */
    public function max(float|int|string|Stringable|null $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['max'] = $value;
        return $new;
    }

    /**
     * Minimum value.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-min
     */
    public function min(float|int|string|Stringable|null $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['min'] = $value;
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
        $new->inputTagAttributes['step'] = $value;
        return $new;
    }

    /**
     * ID of element that lists predefined options suggested to the user.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#the-list-attribute
     */
    public function list(?string $id): self
    {
        $new = clone $this;
        $new->inputTagAttributes['list'] = $id;
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
    public function ariaDescribedBy(string $value): self
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
    public function ariaLabel(string $value): self
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

    public function showOutput(bool $show = true): self
    {
        $new = clone $this;
        $new->showOutput = $show;
        return $new;
    }

    public function outputTagName(string $tagName): self
    {
        if ($tagName === '') {
            throw new InvalidArgumentException('The output tag name it cannot be empty value.');
        }

        $new = clone $this;
        $new->outputTagName = $tagName;
        return $new;
    }

    public function outputTagAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->outputTagAttributes = $attributes;
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

                if ($rule instanceof NumberRule) {
                    if (null !== $min = $rule->getOptions()['min']) {
                        $this->inputTagAttributes['min'] = $min;
                    }
                    if (null !== $max = $rule->getOptions()['max']) {
                        $this->inputTagAttributes['max'] = $max;
                    }
                }
            }
        }
    }

    protected function generateInput(): string
    {
        $value = $this->getAttributeValue();

        if (!is_string($value) && !is_numeric($value) && $value !== null) {
            throw new InvalidArgumentException('Range widget requires a string, numeric or null value.');
        }

        $tag = Html::range($this->getInputName(), $value, $this->getInputTagAttributes());
        if ($this->showOutput) {
            $tag = $tag
                ->showOutput()
                ->outputTagName($this->outputTagName)
                ->outputTagAttributes($this->outputTagAttributes);
        }

        return $tag->render();
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
}
