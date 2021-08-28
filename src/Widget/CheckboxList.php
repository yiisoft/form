<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Closure;
use InvalidArgumentException;
use Stringable;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Form\Widget\Attribute\CommonAttribute;
use Yiisoft\Form\Widget\Attribute\ModelAttribute;
use Yiisoft\Html\Widget\CheckboxList\CheckboxItem;
use Yiisoft\Html\Widget\CheckboxList\CheckboxList as ChecboxListTag;
use Yiisoft\Widget\Widget;

/*
 * Generates a list of checkboxes.
 *
 * A checkbox list allows multiple selection.
 */
final class CheckboxList extends Widget
{
    use CommonAttribute;
    use ModelAttribute;

    private array $containerAttributes = [];
    private ?string $containerTag = 'div';
    /** @psalm-var array<array-key, array<array-key, mixed>> $value */
    private array $individualItemsAttributes = [];
    /** @var array<array-key, string> */
    private array $items = [];
    private array $itemsAttributes = [];
    /** @psalm-var Closure(CheckboxItem):string|null */
    private ?Closure $itemsFormatter = null;
    private string $separator = '';

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
     * The specified attributes for items.
     *
     * @param array $value
     *
     * @return static
     *
     * @psalm-param array<array-key, array<array-key, mixed>> $value
     */
    public function individualItemsAttributes(array $value = []): self
    {
        $new = clone $this;
        $new->individualItemsAttributes = $value;
        return $new;
    }

    /**
     * The data used to generate the list of checkboxes.
     *
     * The array keys are the list of checkboxes values, and the array values are the corresponding labels.
     *
     * Note that the labels will NOT be HTML-encoded, while the values will.
     *
     * @param array<array-key, string> $value
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
     * The items attributes for generating the list of checkboxes tag using {@see CheckBoxList}.
     *
     * @param array $value
     *
     * @return static
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
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
     * @param Closure $value
     *
     * @return static
     *
     * @psalm-param Closure(CheckboxItem):string|null $value
     */
    public function itemsFormatter(?Closure $value): self
    {
        $new = clone $this;
        $new->itemsFormatter = $value;
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
    public function separator(string $value): self
    {
        $new = clone $this;
        $new->separator = $value;
        return $new;
    }

    /**
     * @return string the generated checkbox list.
     */
    protected function run(): string
    {
        $new = clone $this;
        $checkboxList = ChecboxListTag::create(HtmlForm::getInputName($new->formModel, $new->attribute));

        /** @var string */
        $new->containerAttributes['id'] = $new->containerAttributes['id'] ?? $new->getId();

        /** @var bool|float|int|string|Stringable|null */
        $forceUncheckedValue = ArrayHelper::remove($new->attributes, 'forceUncheckedValue', null);

        /** @var iterable<int, scalar|Stringable>|scalar|Stringable|null */
        $value = HtmlForm::getAttributeValue($new->formModel, $new->attribute);

        if (is_object($value)) {
            throw new InvalidArgumentException('CheckboxList widget requires a int|string|iterable|null value.');
        }

        if (is_iterable($value)) {
            $checkboxList = $checkboxList->values($value);
        } elseif (is_scalar($value)) {
            $checkboxList = $checkboxList->value($value);
        }

        if ($new->separator !== '') {
            $checkboxList = $checkboxList->separator($new->separator);
        }

        return $checkboxList
            ->checkboxAttributes($new->attributes)
            ->containerAttributes($new->containerAttributes)
            ->containerTag($new->containerTag)
            ->individualInputAttributes($new->individualItemsAttributes)
            ->itemFormatter($new->itemsFormatter)
            ->items($new->items)
            ->replaceCheckboxAttributes($new->itemsAttributes)
            ->uncheckValue($forceUncheckedValue)
            ->render();
    }
}
