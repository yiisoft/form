<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Closure;
use InvalidArgumentException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Html\Widget\RadioList\RadioItem;
use Yiisoft\Html\Widget\RadioList\RadioList as RadioListTag;

/**
 * Generates a list of radio.
 */
final class RadioList extends Widget
{
    private array $containerAttributes = [];
    private ?string $containerTag = 'div';
    private array $items = [];
    private array $itemsAttributes = [];
    /** @psalm-var Closure(RadioItem):string|null */
    private ?Closure $itemsFormatter = null;

    /**
     * The container attributes for generating the list of checkboxes tag using {@see CheckBoxList}.
     *
     * @param array $value
     *
     * @return static
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
     * @param string|null $value tag name. if `null` disabled rendering.
     *
     * @return static
     */
    public function containerTag(?string $name): self
    {
        $new = clone $this;
        $new->containerTag = $name;
        return $new;
    }

    /**
     * Set whether the element is disabled or not.
     *
     * If this attribute is set to `true`, the element is disabled. Disabled elements are usually drawn with grayed-out
     * text.
     * If the element is disabled, it does not respond to user actions, it cannot be focused, and the command event
     * will not fire. In the case of form elements, it will not be submitted. Do not set the attribute to true, as
     * this will suggest you can set it to false to enable the element again, which is not the case.
     *
     * @param bool $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-disabledformelements-disabled
     */
    public function disabled(bool $value = true): self
    {
        $new = clone $this;
        $new->itemsAttributes['disabled'] = $value;
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
     * @return static
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
     * @return static
     */
    public function itemsAttributes(array $value = []): self
    {
        $new = clone $this;
        $new->attributes['itemsAttributes'] = $value;
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
     * @param Closure $formatter
     *
     * @return static
     */
    public function itemsFormater(?Closure $formatter): self
    {
        $new = clone $this;
        $new->itemsFormatter = $formatter;
        return $new;
    }

    /**
     * The readonly attribute is a boolean attribute that controls whether or not the user can edit the form control.
     * When specified, the element is not mutable.
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-readonly
     */
    public function readonly(): self
    {
        $new = clone $this;
        $new->itemsAttributes['readonly'] = true;
        return $new;
    }

    /**
     * The HTML code that separates items.
     *
     * @param string $value
     *
     * @return static
     */
    public function separator(string $value = ''): self
    {
        $new = clone $this;
        $new->attributes['separator'] = $value;
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
        $new = clone $this;

        $radioList = RadioListTag::create($new->getInputName());

        /** @var string */
        $new->containerAttributes['id'] = $new->containerAttributes['id'] ?? $new->getId();

        /** @var bool|float|int|string|Stringable|null */
        $forceUncheckedValue = ArrayHelper::remove($new->attributes, 'forceUncheckedValue', null);

        $itemsAttributes = $new->attributes['itemsAttributes'] ?? [];

        /** @var string */
        $separator = $new->attributes['separator'] ?? '';

        unset($new->attributes['itemsAttributes'], $new->attributes['separator']);

        /** @var null|scalar|Stringable|iterable<int, Stringable|scalar> */
        $value = $new->getValue();

        if (!is_scalar($value)) {
            throw new InvalidArgumentException('Radio list widget required bool|float|int|string|null.');
        }

        if ($separator !== '') {
            $radioList = $radioList->separator($separator);
        }

        return $radioList
            ->containerAttributes($new->containerAttributes)
            ->containerTag($new->containerTag)
            ->itemFormatter($new->itemsFormatter)
            ->items($new->items)
            ->radioAttributes($new->attributes)
            ->replaceRadioAttributes($itemsAttributes)
            ->uncheckValue($forceUncheckedValue)
            ->value($value)
            ->render();
    }
}
