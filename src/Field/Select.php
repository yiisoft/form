<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Html\Tag\Optgroup;
use Yiisoft\Html\Tag\Option;
use Yiisoft\Html\Tag\Select as SelectTag;

/**
 * A control for selecting amongst a set of options.
 *
 * @link https://html.spec.whatwg.org/multipage/form-elements.html#the-select-element
 */
final class Select extends InputField
{
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
     *
     * @return self
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
        $new->inputTagAttributes['disabled'] = $disabled;
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
        $new->inputTagAttributes['multiple'] = $value;
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
        $new->inputTagAttributes['required'] = $value;
        return $new;
    }

    /**
     * The size of the control.
     *
     * @param int $value The number of options to show to the user.
     *
     * @link https://html.spec.whatwg.org/multipage/form-elements.html#attr-select-size
     */
    public function size(int $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['size'] = $value;
        return $new;
    }

    public function unselectValue(bool|float|int|string|Stringable|null $value): self
    {
        $new = clone $this;
        $new->select = $this->select->unselectValue($value);
        return $new;
    }

    protected function generateInput(): string
    {
        $value = $this->getAttributeValue();
        $multiple = (bool) ($this->inputTagAttributes['multiple'] ?? false);

        if ($multiple) {
            /** @var mixed $value */
            $value ??= [];
            if (!is_iterable($value)) {
                throw new InvalidArgumentException(
                    'Select field with multiple option requires iterable or null value.'
                );
            }
        } else {
            if (!is_bool($value)
                && !is_string($value)
                && !is_numeric($value)
                && $value !== null
                && (!is_object($value) || !method_exists($value, '__toString'))
            ) {
                throw new InvalidArgumentException(
                    'Non-multiple Select field requires a string, numeric, bool, Stringable or null value.'
                );
            }
            $value = $value === null ? [] : [$value];
        }
        /** @psalm-var iterable<int, Stringable|scalar> $value */

        return $this->select
            ->attributes($this->inputTagAttributes)
            ->name($this->getInputName())
            ->values($value)
            ->render();
    }
}
