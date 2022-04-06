<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Closure;
use InvalidArgumentException;
use Stringable;
use Yiisoft\Form\Widget\Attribute\ChoiceAttributes;
use Yiisoft\Html\Widget\RadioList\RadioItem;
use Yiisoft\Html\Widget\RadioList\RadioList as RadioListTag;

use function is_bool;
use function is_iterable;
use function is_object;
use function is_string;

/**
 * Generates a list of radio.
 */
final class RadioList extends ChoiceAttributes
{
    private array $containerAttributes = [];
    private ?string $containerTag = 'div';
    /** @psalm-var array[] */
    private array $individualItemsAttributes = [];
    /** @psalm-var array<array-key, string> */
    private array $items = [];
    private array $itemsAttributes = [];
    /** @psalm-var Closure(RadioItem):string|null */
    private ?Closure $itemsFormatter = null;
    /** @var bool[]|float[]|int[]|string[]|Stringable[] */
    private array $itemsFromValues = [];
    private string $separator = '';
    private ?string $uncheckValue = null;

    /**
     * Focus on the control (put cursor into it) when the page loads.
     * Only one form element could be in focus at the same time.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#autofocusing-a-form-control-the-autofocus-attribute
     */
    public function autofocus(): static
    {
        $new = clone $this;
        $new->containerAttributes['autofocus'] = true;
        return $new;
    }

    /**
     * The container attributes for generating the list of checkboxes tag using {@see CheckBoxList}.
     *
     * @param array $value
     *
     * @return self
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function containerAttributes(array $value): self
    {
        $new = clone $this;
        $new->containerAttributes = $value;
        return $new;
    }

    /**
     * The tag name for the container element.
     *
     * @param string|null $name tag name. if `null` disabled rendering.
     *
     * @return self
     */
    public function containerTag(?string $name = null): self
    {
        $new = clone $this;
        $new->containerTag = $name;
        return $new;
    }

    /**
     * Set the ID of container the widget.
     *
     * @param string|null $id
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#the-id-attribute
     */
    public function id(?string $id): static
    {
        $new = clone $this;
        $new->containerAttributes['id'] = $id;
        return $new;
    }

    /**
     * The specified attributes for items.
     *
     * @param array $value
     *
     * @return self
     *
     * @psalm-param array[] $value
     */
    public function individualItemsAttributes(array $value = []): self
    {
        $new = clone $this;
        $new->individualItemsAttributes = $value;
        return $new;
    }

    /**
     * The data used to generate the list of radios.
     *
     * The array keys are the list of radio values, and the array values are the corresponding labels.
     *
     * Note that the labels will NOT be HTML-encoded, while the values will.
     *
     * @param array $value
     *
     * @return self
     *
     * @psalm-param array<array-key, string> $value
     */
    public function items(array $value = []): self
    {
        $new = clone $this;
        $new->items = $value;
        return $new;
    }

    /**
     * The attributes for generating the list of radio tag using {@see RadioList}.
     *
     * @param array $value
     *
     * @return self
     */
    public function itemsAttributes(array $value = []): self
    {
        $new = clone $this;
        $new->itemsAttributes = $value;
        return $new;
    }

    /**
     * Callable, a callback that can be used to customize the generation of the HTML code corresponding to a single
     * item in $items.
     *
     * The signature of this callback must be:
     *
     * ```php
     * function ($index, $label, $name, $checked, $value)
     * ```
     *
     * @param Closure|null $value
     *
     * @return self
     *
     * @psalm-param Closure(RadioItem):string|null $value
     */
    public function itemsFormatter(?Closure $value): self
    {
        $new = clone $this;
        $new->itemsFormatter = $value;
        return $new;
    }

    /**
     * The data used to generate the list of radios.
     *
     * The array keys are the list of radio values, and the array values are the corresponding labels.
     *
     * @param bool[]|float[]|int[]|string[]|Stringable[] $itemsFromValues
     *
     * @return self
     */
    public function itemsFromValues(array $itemsFromValues = []): self
    {
        $new = clone $this;
        $new->itemsFromValues = $itemsFromValues;
        return $new;
    }

    /**
     * The HTML code that separates items.
     *
     * @param string $value
     *
     * @return self
     */
    public function separator(string $value = ''): self
    {
        $new = clone $this;
        $new->separator = $value;
        return $new;
    }

    /**
     * The tabindex global attribute indicates that its element can be focused, and where it participates in sequential
     * keyboard navigation (usually with the Tab key, hence the name).
     *
     * It accepts an integer as a value, with different results depending on the integer's value:
     *
     * - A negative value (usually tabindex="-1") means that the element is not reachable via sequential keyboard
     * navigation, but could be focused with Javascript or visually. It's mostly useful to create accessible widgets
     * with JavaScript.
     * - tabindex="0" means that the element should be focusable in sequential keyboard navigation, but its order is
     * defined by the document's source order.
     * - A positive value means the element should be focusable in sequential keyboard navigation, with its order
     * defined by the value of the number. That is, tabindex="4" is focused before tabindex="5", but after tabindex="3".
     *
     * @param int $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/interaction.html#attr-tabindex
     */
    public function tabIndex(int $value): static
    {
        $new = clone $this;
        $new->containerAttributes['tabindex'] = $value;
        return $new;
    }

    /**
     * @param bool|float|int|string|Stringable|null $value Value that corresponds to "unchecked" state of the input.
     *
     * @return static
     */
    public function uncheckValue(float|Stringable|bool|int|string|null $value): self
    {
        $new = clone $this;
        $new->uncheckValue = $value === null ? null : (string) $value;
        return $new;
    }

    /**
     * Generates a list of radio buttons.
     *
     * A radio button list is like a checkbox list, except that it only allows single selection.
     *
     * @return string the generated radio button list
     */
    protected function run(): string
    {
        /** @psalm-var array[] */
        [$attributes, $containerAttributes] = $this->buildList($this->attributes, $this->containerAttributes);

        /**
         * @var iterable<int, scalar|Stringable>|scalar|Stringable|null
         *
         * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-value
         */
        $value = $attributes['value'] ?? $this->getAttributeValue();
        unset($attributes['value']);

        if (is_iterable($value) || is_object($value)) {
            throw new InvalidArgumentException('RadioList widget value can not be an iterable or an object.');
        }

        $name = $this->getInputName();

        /** @var string */
        if (!empty($attributes['name']) && is_string($attributes['name'])) {
            $name = $attributes['name'];
        }

        $radioList = RadioListTag::create($name);

        if ($this->items !== []) {
            $radioList = $radioList->items($this->items, $this->getEncode());
        } elseif ($this->itemsFromValues !== []) {
            $radioList = $radioList->itemsFromValues($this->itemsFromValues, $this->getEncode());
        }

        if ($this->separator !== '') {
            $radioList = $radioList->separator($this->separator);
        }

        if ($this->itemsAttributes !== []) {
            $radioList = $radioList->replaceRadioAttributes($this->itemsAttributes);
        }

        return $radioList
            ->containerAttributes($containerAttributes)
            ->containerTag($this->containerTag)
            ->individualInputAttributes($this->individualItemsAttributes)
            ->itemFormatter($this->itemsFormatter)
            ->radioAttributes($attributes)
            ->uncheckValue($this->uncheckValue)
            ->value(is_bool($value) ? (int) $value : $value)
            ->render();
    }
}
