<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use BackedEnum;
use InvalidArgumentException;
use Stringable;
use Yiisoft\Form\Field\Base\EnrichFromValidationRules\EnrichFromValidationRulesInterface;
use Yiisoft\Form\Field\Base\EnrichFromValidationRules\EnrichFromValidationRulesTrait;
use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassInterface;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassTrait;
use Yiisoft\Html\Tag\Optgroup;
use Yiisoft\Html\Tag\Option;
use Yiisoft\Html\Tag\Select as SelectTag;

use function is_scalar;

/**
 * Represents `<select>` element that provides a menu of options.
 *
 * @link https://html.spec.whatwg.org/multipage/form-elements.html#the-select-element
 * @link https://developer.mozilla.org/docs/Web/HTML/Element/select
 */
final class Select extends InputField implements EnrichFromValidationRulesInterface, ValidationClassInterface
{
    use EnrichFromValidationRulesTrait;
    use ValidationClassTrait;

    private SelectTag $select;

    public function __construct()
    {
        $this->select = SelectTag::tag();
    }

    public function items(Optgroup|Option ...$items): self
    {
        $new = clone $this;
        $new->select = $this->select->items(...$items);
        return $new;
    }

    public function options(Option ...$options): self
    {
        return $this->items(...$options);
    }

    /**
     * @param array $data Options data. The array keys are option values, and the array values are the corresponding
     * option labels. The array can also be nested (i.e. some array values are arrays too). For each sub-array,
     * an option group will be generated whose label is the key associated with the sub-array.
     *
     * Example:
     * ```php
     * [
     *     '1' => 'Santiago',
     *     '2' => 'Concepcion',
     *     '3' => 'Chillan',
     *     '4' => 'Moscow'
     *     '5' => 'San Petersburg',
     *     '6' => 'Novosibirsk',
     *     '7' => 'Ekaterinburg'
     * ];
     * ```
     *
     * Example with options groups:
     * ```php
     * [
     *     '1' => [
     *         '1' => 'Santiago',
     *         '2' => 'Concepcion',
     *         '3' => 'Chillan',
     *     ],
     *     '2' => [
     *         '4' => 'Moscow',
     *         '5' => 'San Petersburg',
     *         '6' => 'Novosibirsk',
     *         '7' => 'Ekaterinburg'
     *     ],
     * ];
     * ```
     * @param bool $encode Whether option content should be HTML-encoded.
     * @param array[] $optionsAttributes Array of option attribute sets indexed by option values from {@see $data}.
     * @param array[] $groupsAttributes Array of group attribute sets indexed by group labels from {@see $data}.
     *
     * @psalm-param array<array-key, string|array<array-key,string>> $data
     */
    public function optionsData(
        array $data,
        bool $encode = true,
        array $optionsAttributes = [],
        array $groupsAttributes = []
    ): self {
        $new = clone $this;
        $new->select = $this->select->optionsData($data, $encode, $optionsAttributes, $groupsAttributes);
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
     * @param bool $value Whether the user is to be allowed to select zero or more options.
     *
     * @link https://html.spec.whatwg.org/multipage/form-elements.html#attr-select-multiple
     */
    public function multiple(bool $value = true): self
    {
        $new = clone $this;
        $new->inputAttributes['multiple'] = $value;
        return $new;
    }

    /**
     * @param string|null $text Text of the option that has dummy value and is rendered as an invitation to select
     * a value.
     */
    public function prompt(?string $text): self
    {
        $new = clone $this;
        $new->select = $this->select->prompt($text);
        return $new;
    }

    /**
     * @param Option|null $option Option that has dummy value and is rendered as an invitation to select a value.
     */
    public function promptOption(?Option $option): self
    {
        $new = clone $this;
        $new->select = $this->select->promptOption($option);
        return $new;
    }

    /**
     * A boolean attribute. When specified, the element is required.
     *
     * @param bool $value Whether the control is required for form submission.
     *
     * @link https://html.spec.whatwg.org/multipage/form-elements.html#attr-select-required
     */
    public function required(bool $value = true): self
    {
        $new = clone $this;
        $new->inputAttributes['required'] = $value;
        return $new;
    }

    /**
     * The size of the control.
     *
     * @param int|null $value The number of options to show to the user.
     *
     * @link https://html.spec.whatwg.org/multipage/form-elements.html#attr-select-size
     */
    public function size(?int $value): self
    {
        $new = clone $this;
        $new->inputAttributes['size'] = $value;
        return $new;
    }

    public function unselectValue(bool|float|int|string|Stringable|null $value): self
    {
        $new = clone $this;
        $new->select = $this->select->unselectValue($value);
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
        $multiple = $this->inputAttributes['multiple'] ?? false;

        if ($multiple) {
            $value ??= [];
            if (!is_iterable($value)) {
                throw new InvalidArgumentException(
                    'Select field with multiple option requires iterable or null value.'
                );
            }
        } else {
            if (
                !is_scalar($value)
                && !$value instanceof Stringable
                && !$value instanceof BackedEnum
                && $value !== null
            ) {
                throw new InvalidArgumentException(
                    'Non-multiple select field requires a string, Stringable, numeric, bool, backed enumeration or null value.'
                );
            }
            $value = $value === null ? [] : [$value];
        }

        /** @psalm-suppress MixedArgument We guess that enrichment contain correct values. */
        $selectAttributes = array_merge(
            $this->enrichment['inputAttributes'] ?? [],
            $this->getInputAttributes()
        );

        /** @psalm-var iterable<int, Stringable|scalar|BackedEnum> $value */
        return $this->select
            ->addAttributes($selectAttributes)
            ->name($this->getName())
            ->values($value)
            ->render();
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
}
