<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;
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
     * Generates a list of input fields.
     *
     * This method is mainly called by {@see ListBox()}, {@see RadioList()} and {@see CheckboxList()}.
     *
     * @return string the generated input list
     */
    public function run(): string
    {
        $new = clone $this;
        $type = $new->type;

        if (!$new->noUnselect) {
            $new->options['unselect'] =  $new->options['unselect'] ?? $new->unselect;
        }

        if (!empty($new->getId())) {
            $new->options['id'] = $new->getId();
        }

        return Html::$type($new->getName(), $new->getValue(), $new->items, $new->options);
    }

    /**
     * Configure the FormModel options for the widget.
     *
     * @param FormModelInterface $data Represents the {@see FormModel}.
     * @param string $attribute It is the property defined in the {@see FormModel}.
     * @param array $options The HTML attributes for the widget container tag. The following special options are
     * recognized. {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
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
     * It allows defining the character set used to generate the widget id. {@see HtmlForm::getInputId()}
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
     * @param string $value
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
     * @param callable $value
     *
     * @return self
     */
    public function item(callable $value): self
    {
        $new = clone $this;
        $new->options['item'] = $value;
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
     * Lets you specify the input control to generate.
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

        return $id !== false ? $id : '';
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
