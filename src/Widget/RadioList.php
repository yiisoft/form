<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Closure;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Html\Widget\RadioList\RadioItem;
use Yiisoft\Widget\Widget;

final class RadioList extends Widget
{
    private FormModelInterface $data;
    private string $attribute;
    private array $options = [];
    private array $items = [];
    private bool $noUnselect = false;

    /**
     * @psalm-var Closure(RadioItem):string|null
     */
    private ?Closure $itemFormatter = null;

    /**
     * Generates a list of radio buttons.
     *
     * A radio button list is like a checkbox list, except that it only allows single selection.
     *
     * @return string the generated radio button list
     */
    public function run(): string
    {
        return ListInput::widget()
            ->type('radioList')
            ->config($this->data, $this->attribute, $this->options)
            ->items($this->items)
            ->item($this->itemFormatter)
            ->noUnselect($this->noUnselect)
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
     * @return self
     */
    public function item(?Closure $formatter): self
    {
        $new = clone $this;
        $new->itemFormatter = $formatter;
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
     */
    public function items(array $value = []): self
    {
        $new = clone $this;
        $new->items = $value;
        return $new;
    }

    /**
     * The options for generating the list of radio tag using {@see RadioList}.
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
     * Whether to HTML-encode the list of radio labels.
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
        $new->options['itemOptions']['encode'] = $value;
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
     * Null to render list of radio without container {@see Html::tag()}.
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
     * The value that should be submitted when none of the list of radio is selected.
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
        $new->options['unselect'] = $value;
        return $new;
    }
}
