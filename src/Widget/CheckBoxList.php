<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Widget\Widget;
use Yiisoft\Form\FormModelInterface;

final class CheckBoxList extends Widget
{
    private FormModelInterface $data;
    private string $attribute;
    private array $options = [];
    private array $items = [];
    private bool $noUnselect = false;
    private string $unselect = '';

    /**
     * Generates a list of checkboxes.
     *
     * A checkbox list allows multiple selection, like {@see ListBox}.
     *
     * @return string the generated checkbox list.
     * @throws \Yiisoft\Factory\Exceptions\InvalidConfigException
     */
    public function run(): string
    {
        return ListInput::widget()
            ->type('checkBoxList')
            ->config($this->data, $this->attribute, $this->options)
            ->items($this->items)
            ->noUnselect($this->noUnselect)
            ->unselect($this->unselect)
            ->run();
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
     * Whether to HTML-encode the list of checkboxes labels.
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
     * @return self
     */
    public function disabled(bool $value = true): self
    {
        $new = clone $this;
        $new->options['disabled'] = $value;
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
     * The data used to generate the list of checkboxes.
     *
     * The array keys are the list of checkboxes values, and the array values are the corresponding labels.
     *
     * Note that the labels will NOT be HTML-encoded, while the values will.
     *
     * @param array $value
     *
     * @return self
     */
    public function items(array $value = []): self
    {
        $new = clone $this;
        $new->items = $value;
        return $new;
    }

    /**
     * The options for generating the list of checkboxes tag using {@see CheckBoxList}.
     *
     * @param array $value
     *
     * @return self
     */
    public function itemOptions(array $value = []): self
    {
        $new = clone $this;
        $new->options['itemOptions'] = $value;
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
     * The HTML code that separates items.
     *
     * @param string $value
     *
     * @return self
     */
    public function separator(string $value = ''): self
    {
        $new = clone $this;
        $new->options['separator'] = $value;
        return $new;
    }

    /**
     * The tag name of the container element.
     *
     * Null to render list of checkboxes without container {@see \Yiisoft\Html\Html::tag()}.
     *
     * @param string|null $value
     *
     * @return self
     */
    public function tag(?string $value = null): self
    {
        $new = clone $this;
        $new->options['tag'] = $value;
        return $new;
    }

    /**
     * The value that should be submitted when none of the list of checkboxes is selected.
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
