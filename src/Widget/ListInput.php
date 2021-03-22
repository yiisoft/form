<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Closure;
use RuntimeException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Html\Html;
use Yiisoft\Html\Widget\CheckboxList\CheckboxItem;
use Yiisoft\Html\Widget\RadioList\RadioItem;
use Yiisoft\Widget\Widget;

final class ListInput extends Widget
{
    private ?string $id = null;
    private FormModelInterface $data;
    private string $attribute;
    private array $options = [];
    private string $charset = 'UTF-8';
    private array $items = [];
    private bool $noUnselect = false;
    private string $unselect = '';
    private string $type;

    /**
     * @psalm-var Closure(CheckboxItem):string|Closure(RadioItem):string|null
     */
    private ?Closure $itemFormatter = null;

    /**
     * Generates a list of input fields.
     *
     * This method is mainly called by {@see ListBox()}, {@see RadioList()} and {@see CheckboxList()}.
     *
     * @return string the generated input list
     */
    public function run(): string
    {
        $new = clone $this;
        $type = strtolower($new->type);

        $uncheckValue = ArrayHelper::remove($new->options, 'unselect');
        if (!$new->noUnselect) {
            $uncheckValue ??= $new->unselect;
        }

        if (!empty($new->getId())) {
            $new->options['id'] = $new->getId();
        }

        $containerTag = ArrayHelper::remove($new->options, 'tag', 'div');
        $separator = ArrayHelper::remove($new->options, 'separator', "\n");
        $encode = ArrayHelper::remove($new->options, 'encode', true);
        $disabled = ArrayHelper::remove($new->options, 'disabled', false);

        switch ($type) {
            case 'checkboxlist':
                $checkboxAttributes = ArrayHelper::remove($new->options, 'itemOptions', []);
                $encodeLabels = ArrayHelper::remove($checkboxAttributes, 'encode', true);

                /** @psalm-var Closure(CheckboxItem):string|null $itemFormatter */
                $itemFormatter = $this->itemFormatter;

                $value = $new->getValue();
                return Html::checkboxList($new->getName())
                    ->values(!is_iterable($value) ? [$value] : $value)
                    ->uncheckValue($uncheckValue)
                    ->items($new->items, $encodeLabels)
                    ->itemFormatter($itemFormatter)
                    ->separator($separator)
                    ->containerTag($containerTag)
                    ->containerAttributes($new->options)
                    ->checkboxAttributes($checkboxAttributes)
                    ->disabled($disabled)
                    ->render();

            case 'radiolist':
                $radioAttributes = ArrayHelper::remove($new->options, 'itemOptions', []);
                $encodeLabels = ArrayHelper::remove($radioAttributes, 'encode', true);

                /** @psalm-var Closure(RadioItem):string|null $itemFormatter */
                $itemFormatter = $this->itemFormatter;

                $value = $new->getValue();
                return Html::radioList($new->getName())
                    ->value($value)
                    ->uncheckValue($uncheckValue)
                    ->items($new->items, $encodeLabels)
                    ->itemFormatter($itemFormatter)
                    ->separator($separator)
                    ->containerTag($containerTag)
                    ->containerAttributes($new->options)
                    ->radioAttributes($radioAttributes)
                    ->disabled($disabled)
                    ->render();

            case 'listbox':
            case 'dropdownlist':
                $groups = ArrayHelper::remove($new->options, 'groups', []);
                $optionsAttributes = ArrayHelper::remove($new->options, 'options', []);

                $items = [];
                foreach ($new->items as $value => $content) {
                    if (is_array($content)) {
                        $groupAttrs = $groups[$value] ?? [];
                        $groupAttrs['encode'] = false;
                        if (!isset($groupAttrs['label'])) {
                            $groupAttrs['label'] = $value;
                        }
                        $options = [];
                        foreach ($content as $v => $c) {
                            $options[] = Html::option($c, $v)
                                ->attributes($optionsAttributes[$v] ?? [])
                                ->encode($encode);
                        }
                        $items[] = Html::optgroup()
                            ->options(...$options)
                            ->attributes($groupAttrs);
                    } else {
                        $items[] = Html::option($content, $value)
                            ->attributes($optionsAttributes[$value] ?? [])
                            ->encode($encode);
                    }
                }

                $promptOption = null;
                $prompt = ArrayHelper::remove($new->options, 'prompt');
                if ($prompt) {
                    $promptText = $prompt['text'] ?? '';
                    if ($promptText) {
                        $promptOption = Html::option($promptText)
                            ->attributes($prompt['options'] ?? []);
                    }
                }

                if ($type === 'listbox') {
                    $new->options['size'] ??= 4;
                }

                $value = $new->getValue();
                return Html::select($new->getName())
                    ->values(!is_iterable($value) ? [$value] : $value)
                    ->unselectValue($type === 'listbox' ? $uncheckValue : null)
                    ->promptOption($promptOption)
                    ->items(...$items)
                    ->attributes($new->options)
                    ->disabled($disabled)
                    ->render();
        }

        throw new RuntimeException('Unknown type: ' . $type);
    }

    /**
     * Set form model, name and options for the widget.
     *
     * @param FormModelInterface $data Form model.
     * @param string $attribute Form model property this widget is rendered for.
     * @param array $options The HTML attributes for the widget container tag.
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @return self
     */
    public function config(FormModelInterface $data, string $attribute, array $options = []): self
    {
        $new = clone $this;
        $new->data = $data;
        $new->attribute = $attribute;
        $new->options = $options;
        return $new;
    }

    /**
     * Set the character set used to generate the widget id. See {@see HtmlForm::getInputId()}.
     *
     * @param string $value
     *
     * @return self
     */
    public function charset(string $value): self
    {
        $new = clone $this;
        $new->charset = $value;
        return $new;
    }

    /**
     * Set the Id of the widget.
     *
     * @param string|null $value
     *
     * @return self
     */
    public function id(?string $value): self
    {
        $new = clone $this;
        $new->id = $value;
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
     * @return self
     */
    public function item(?Closure $formatter): self
    {
        $new = clone $this;
        $new->itemFormatter = $formatter;
        return $new;
    }

    /**
     * The option data items.
     *
     * The array keys are option values, and the array values are the corresponding option labels. The array can also
     * be nested (i.e. some array values are arrays too). For each sub-array, an option group will be generated whose
     * label is the key associated with the sub-array. If you have a list of data {@see FormModel}, you may convert
     * them into the format described above using {@see \Yiisoft\Arrays\ArrayHelper::map()}
     *
     * Example:
     * ```php
     * [
     *     '1' => 'Santiago',
     *     '2' => 'Concepcion',
     *     '3' => 'Chillan',
     *     '4' => 'Moscu'
     *     '5' => 'San Petersburgo',
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
     *         '5' => 'San Petersburgo',
     *         '6' => 'Novosibirsk',
     *         '7' => 'Ekaterinburgo'
     *     ],
     * ];
     * ```
     *
     * @param array $value
     *
     * @return self
     */
    public function items(array $value): self
    {
        $new = clone $this;
        $new->items = $value;
        return $new;
    }

    /**
     * Allows you to disable the widgets hidden input tag.
     *
     * @param bool $value
     *
     * @return self
     */
    public function noUnselect(bool $value = true): self
    {
        $new = clone $this;
        $new->noUnselect = $value;
        return $new;
    }

    /**
     * Type of the input control to use.
     *
     * @param string $value
     *
     * @return self
     */
    public function type(string $value): self
    {
        $new = clone $this;
        $new->type = $value;
        return $new;
    }

    /**
     * The value that should be submitted when none of the listbox is selected.
     *
     * You may set this option to be null to prevent default value submission. If this option is not set, an empty
     * string will be submitted.
     *
     * @param string $value
     *
     * @return self
     */
    public function unselect(string $value = ''): self
    {
        $new = clone $this;
        $new->unselect = $value;
        return $new;
    }

    private function getId(): string
    {
        $id = $this->options['id'] ?? $this->id;

        if ($id === null) {
            $id = HtmlForm::getInputId($this->data, $this->attribute, $this->charset);
        }

        return $id !== false ? (string)$id : '';
    }

    private function getName(): string
    {
        return ArrayHelper::remove($this->options, 'name', HtmlForm::getInputName($this->data, $this->attribute));
    }

    private function getValue()
    {
        $value = HtmlForm::getAttributeValue($this->data, $this->attribute);

        if ($value !== null && is_scalar($value)) {
            $value = (string)$value;
        }

        return ArrayHelper::remove(
            $this->options,
            'value',
            $value
        );
    }
}
