<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Form\Widget\Attribute\ChoiceAttributes;
use Yiisoft\Html\Tag\Optgroup;
use Yiisoft\Html\Tag\Option;
use Yiisoft\Html\Tag\Select as SelectTag;

/**
 * Generates a drop-down list for the given form attribute.
 *
 * The selection of the drop-down list is taken from the value of the form attribute.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/select.html
 */
final class Select extends ChoiceAttributes
{
    private array $items = [];
    private array $itemsAttributes = [];
    private array $groups = [];
    /** @var string[] */
    private array $optionsData = [];
    private string $prompt = '';
    private ?Option $promptTag = null;
    private ?string $unselectValue = null;

    /**
     * The attributes for the optgroup tags.
     *
     * The structure of this is similar to that of 'attributes', except that the array keys represent the optgroup
     * labels specified in $items.
     *
     * ```php
     * [
     *     'groups' => [
     *         '1' => ['label' => 'Chile'],
     *         '2' => ['label' => 'Russia']
     *     ],
     * ];
     * ```
     *
     * @param array $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/optgroup.html#optgroup
     */
    public function groups(array $value = []): self
    {
        $new = clone $this;
        $new->groups = $value;
        return $new;
    }

    /**
     * The option data items.
     *
     * The array keys are option values, and the array values are the corresponding option labels. The array can also
     * be nested (i.e. some array values are arrays too). For each sub-array, an option group will be generated whose
     * label is the key associated with the sub-array. If you have a list of data {@see Widget}, you may convert
     * them into the format described above using {@see \Yiisoft\Arrays\ArrayHelper::map()}
     *
     * Example:
     * ```php
     * [
     *     '1' => 'Santiago',
     *     '2' => 'Concepcion',
     *     '3' => 'Chillan',
     *     '4' => 'Moscu'
     *     '5' => 'San Petersburg',
     *     '6' => 'Novosibirsk',
     *     '7' => 'Ekaterinburgo'
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
     *         '4' => 'Moscu',
     *         '5' => 'San Petersburg',
     *         '6' => 'Novosibirsk',
     *         '7' => 'Ekaterinburgo'
     *     ],
     * ];
     * ```
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
     * The HTML attributes for items. The following special options are recognized.
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
     * The Boolean multiple attribute, if set, means the widget accepts one or more values.
     *
     * Most browsers displaying a scrolling list box for a <select> control with the multiple attribute set versus a
     * single line dropdown when the attribute is false.
     *
     * @param bool $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-select-multiple
     */
    public function multiple(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['multiple'] = $value;
        return $new;
    }

    /**
     * @param string[] $data
     *
     * @return static
     */
    public function optionsData(array $data): self
    {
        $new = clone $this;
        $new->optionsData = $data;
        return $new;
    }

    /**
     * The prompt option can be used to define a string that will be displayed on the first line of the drop-down list
     * widget.
     *
     * @param string $value
     *
     * @return static
     */
    public function prompt(string $value): self
    {
        $new = clone $this;
        $new->prompt = $value;
        return $new;
    }

    /**
     * The prompt option tag can be used to define an object Stringable that will be displayed on the first line of the
     * drop-down list widget.
     *
     * @param Option|null $value
     *
     * @return static
     */
    public function promptTag(?Option $value): self
    {
        $new = clone $this;
        $new->promptTag = $value;
        return $new;
    }

    /**
     * The height of the <select> with multiple is true.
     *
     * @param int $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-select-size
     */
    public function size(int $value): self
    {
        $new = clone $this;
        $new->attributes['size'] = $value;
        return $new;
    }

    public function unselectValue(?string $value): self
    {
        $new = clone $this;
        $new->unselectValue = $value;
        return $new;
    }

    /**
     * @return Optgroup[]|Option[]
     */
    private function renderItems(array $values = []): array
    {
        $items = [];
        $itemsAttributes = $this->itemsAttributes;

        /** @var array|string $content */
        foreach ($values as $value => $content) {
            if (is_array($content)) {
                /** @var array */
                $groupAttrs = $this->groups[$value] ?? [];
                $options = [];

                /** @var string $c */
                foreach ($content as $v => $c) {
                    /** @var array */
                    $itemsAttributes[$v] ??= [];
                    $options[] = Option::tag()->attributes($itemsAttributes[$v])->content($c)->value($v);
                }

                $items[] = Optgroup::tag()->attributes($groupAttrs)->options(...$options);
            } else {
                /** @var array */
                $itemsAttributes[$value] ??= [];
                $items[] = Option::tag()->attributes($itemsAttributes[$value])->content($content)->value($value);
            }
        }

        return $items;
    }

    /**
     * @return string the generated drop-down list tag.
     */
    protected function run(): string
    {
        $attributes = $this->build($this->attributes);

        /**
         * @psalm-var iterable<int, Stringable|scalar>|scalar|null $value
         *
         * @link https://www.w3.org/TR/2011/WD-html5-20110525/association-of-controls-and-forms.html#concept-fe-value
         */
        $value = $attributes['value'] ?? $this->getAttributeValue();
        unset($attributes['value']);

        if (is_object($value)) {
            throw new InvalidArgumentException('Select widget value can not be an object.');
        }

        $select = SelectTag::tag();

        if (array_key_exists('multiple', $attributes) && !array_key_exists('size', $attributes)) {
            $attributes['size'] = 4;
        }

        if ($this->prompt !== '') {
            $select = $select->prompt($this->prompt);
        }

        if ($this->promptTag !== null) {
            $select = $select->promptOption($this->promptTag);
        }

        if ($this->items !== []) {
            $select = $select->items(...$this->renderItems($this->items));
        } elseif ($this->optionsData !== []) {
            $select = $select->optionsData($this->optionsData, $this->getEncode());
        }

        if (is_iterable($value)) {
            $select = $select->values($value);
        } elseif (null !== $value) {
            $select = $select->value($value);
        }

        return $select->attributes($attributes)->unselectValue($this->unselectValue)->render();
    }
}
