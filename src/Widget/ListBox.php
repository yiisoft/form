<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Widget\Widget;

final class ListBox extends Widget
{
    private ?string $id = null;
    private FormModelInterface $data;
    private string $attribute;
    private array $options = [];
    private array $items = [];
    private bool $noUnselect = false;
    private string $unselect = '';
    private string $type;

    /**
     * Generates a list box.
     *
     * The selection of the list box is taken from the value of the model attribute.
     *
     * @throws InvalidConfigException
     *
     * @return string the generated list box tag.
     */
    public function run(): string
    {

        return ListInput::Widget()
            ->type('listBox')
            ->config($this->data, $this->attribute, $this->options)
            ->items($this->items)
            ->noUnselect($this->noUnselect)
            ->unselect($this->unselect)
            ->run();
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
     * Whether to HTML-encode the listbox labels.
     *
     * Defaults to true. This option is ignored if item option is set.
     *
     * @param bool $value
     *
     * @return self
     */
    public function noEncode(bool $value = false): self
    {
        $new = clone $this;
        $new->options['encode'] = $value;
        return $new;
    }

    /**
     * Whether to encode spaces in option prompt and option value with &nbsp; character. Defaults to false.
     *
     * @param bool $value
     *
     * @return self
     */
    public function encodeSpaces(bool $value = true): self
    {
        $new = clone $this;
        $new->options['encodeSpaces'] = $value;
        return $new;
    }

    /**
     * The attributes for the optgroup tags.
     *
     * The structure of this is similar to that of 'options', except that the array keys represent the optgroup labels
     * specified in $items.
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
     * @return self
     */
    public function groups(array $value = []): self
    {
        $new = clone $this;
        $new->options['groups'] = $value;
        return $new;
    }

    /**
     * The option data items.
     *
     * The array keys are option values, and the array values are the corresponding option labels. The array can also
     * be nested (i.e. some array values are arrays too). For each sub-array, an option group will be generated whose
     * label is the key associated with the sub-array. If you have a list of data {@see FormModel}, you may convert
     * them into the format described above using {@se Yiisoft\Arrays\ArrayHelper::map()}
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
     * The Boolean multiple attribute, if set, means the widget accepts one or more values.
     *
     * Most browsers displaying a scrolling list box for a <select> control with the multiple attribute set versus a
     * single line dropdown when the attribute is false.
     *
     * @param bool $value
     *
     * @return self
     */
    public function multiple(bool $value = true): self
    {
        $new = clone $this;
        $new->options['multiple'] = $value;
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
     * Prompt text to be displayed as the first option, you can use an array to override the value and to set other
     * tag attributes:
     *
     * ```php
     * [
     *     'prompt' => [
     *         'text' => 'Select City Birth',
     *         'options' => [
     *             'value' => '0',
     *             'selected' => 'selected'
     *         ],
     *     ],
     * ]
     * ```
     *
     * @param array value
     *
     * @return self
     */
    public function prompt(array $value = []): self
    {
        $new = clone $this;
        $new->options['prompt'] = $value;
        return $new;
    }

    /**
     * The Boolean required attribute which, if present, indicates that the user must specify a value for the input
     * before the owning form can be submitted.
     *
     * @param bool $value
     *
     * @return self
     */
    public function required(bool $value = true): self
    {
        $new = clone $this;
        $new->options['required'] = $value;
        return $new;
    }

    /**
     * The height of the <select> with multiple is true.
     *
     * Default value is 4.
     *
     * @param int $value
     *
     * @return self
     */
    public function size(int $value = 4): self
    {
        $new = clone $this;
        $new->options['size'] = $value;
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
}
