<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Closure;
use InvalidArgumentException;
use Stringable;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Form\Widget\Attribute\GlobalAttributes;
use Yiisoft\Html\Widget\CheckboxList\CheckboxItem;
use Yiisoft\Html\Widget\CheckboxList\CheckboxList as CheckboxListTag;

/*
 * Generates a list of checkboxes.
 *
 * A checkbox list allows multiple selection.
 */
final class CheckboxList extends AbstractWidget
{
    use GlobalAttributes;

    private array $containerAttributes = [];
    private ?string $containerTag = 'div';
    /** @psalm-var array[] $value */
    private array $individualItemsAttributes = [];
    /** @var string[] */
    private array $items = [];
    /** @var bool[]|float[]|int[]|string[]|Stringable[] */
    private array $itemsAsValues = [];
    private array $itemsAttributes = [];
    /** @psalm-var Closure(CheckboxItem):string|null */
    private ?Closure $itemsFormatter = null;
    /** @var bool[]|float[]|int[]|string[]|Stringable[] */
    private array $itemsFromValues = [];
    private string $separator = "\n";

    /**
     * The container attributes for generating the list of checkboxes tag using {@see CheckBoxList}.
     *
     * @param array $attributes
     *
     * @return static
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function containerAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->containerAttributes = $attributes;
        return $new;
    }

    /**
     * The tag name for the container element.
     *
     * @param string|null $tag tag name. if `null` disabled rendering.
     *
     * @return static
     */
    public function containerTag(?string $tag = null): self
    {
        $new = clone $this;
        $new->containerTag = $tag;
        return $new;
    }

    /**
     * The specified attributes for items.
     *
     * @param array $attributes
     *
     * @return static
     *
     * @psalm-param array[] $attributes
     */
    public function individualItemsAttributes(array $attributes = []): self
    {
        $new = clone $this;
        $new->individualItemsAttributes = $attributes;
        return $new;
    }

    /**
     * The data used to generate the list of checkboxes.
     *
     * The array keys are the list of checkboxes values, and the array key values are the corresponding labels.
     *
     * @param string[] $items
     *
     * @return static
     */
    public function items(array $items = []): self
    {
        $new = clone $this;
        $new->items = $items;
        return $new;
    }

    /**
     * The items attribute for generating the list of checkboxes tag using {@see CheckBoxList}.
     *
     * @param array $attributes
     *
     * @return static
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function itemsAttributes(array $attributes = []): self
    {
        $new = clone $this;
        $new->itemsAttributes = $attributes;
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
     * @param Closure|null $formatter
     *
     * @return static
     *
     * @psalm-param Closure(CheckboxItem):string|null $formatter
     */
    public function itemsFormatter(?Closure $formatter): self
    {
        $new = clone $this;
        $new->itemsFormatter = $formatter;
        return $new;
    }

    /**
     * The data used to generate the list of checkboxes.
     *
     * The array keys are the list of checkboxes values, and the array values are the corresponding labels.
     *
     * @param bool[]|float[]|int[]|string[]|Stringable[] $itemsFromValues
     *
     * @return static
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
     * @param string $separator
     *
     * @return static
     */
    public function separator(string $separator): self
    {
        $new = clone $this;
        $new->separator = $separator;
        return $new;
    }

    /**
     * @return string the generated checkbox list.
     */
    protected function run(): string
    {
        $new = clone $this;

        /**
         *  @var iterable<int, scalar|Stringable>|scalar|Stringable|null
         *
         *  @link https://html.spec.whatwg.org/multipage/input.html#attr-input-value
         */
        $value = HtmlForm::getAttributeValue($new->getFormModel(), $new->getAttribute());

        if (!is_iterable($value) && null !== $value) {
            throw new InvalidArgumentException('CheckboxList widget must be a array or null value.');
        }

        $checkboxList = CheckboxListTag::create($new->getName());

        $new->containerAttributes['id'] = $new->containerAttributes['id'] ?? $new->getId();

        /** @var bool */
        $itemsEncodeLabels = $new->attributes['itemsEncodeLabels'] ?? true;

        /** @var bool */
        $itemsAsEncodeLabels = $new->attributes['itemsAsEncodeLabels'] ?? true;

        if ($new->items !== []) {
            $checkboxList = $checkboxList->items($new->items, $itemsEncodeLabels);
        } elseif ($new->itemsFromValues !== []) {
            $checkboxList = $checkboxList->itemsFromValues($new->itemsFromValues, $itemsAsEncodeLabels);
        }

        if ($new->itemsAttributes !== []) {
            $checkboxList = $checkboxList->replaceCheckboxAttributes($new->itemsAttributes);
        }

        return $checkboxList
            ->checkboxAttributes($new->attributes)
            ->containerAttributes($new->containerAttributes)
            ->containerTag($new->containerTag)
            ->individualInputAttributes($new->individualItemsAttributes)
            ->itemFormatter($new->itemsFormatter)
            ->separator($new->separator)
            ->values($value ?? [])
            ->render();
    }
}
