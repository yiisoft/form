<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Widget\Widget;
use Yiisoft\Form\FormModelInterface;

final class FileInput extends Widget
{
    private FormModelInterface $data;
    private string $attribute;
    private array $options = [];
    private bool $withHiddenInput = false;

    /**
     * Generates a file input tag for the given form attribute.
     *
     * @return string the generated input tag.
     */
    public function run(): string
    {
        $new = clone $this;

        $hiddenOptions = ['id' => false, 'value' => ''];

        if (isset($new->options['name'])) {
            $hiddenOptions['name'] = $new->options['name'];
        }

        /** make sure disabled input is not sending any value */
        if (!empty($new->options['disabled'])) {
            $hiddenOptions['disabled'] = $new->options['disabled'];
        }

        $hiddenOptions = ArrayHelper::merge($hiddenOptions, ArrayHelper::remove($new->options, 'hiddenOptions', []));

        /**
         * Add a hidden field so that if a form only has a file field, we can still use isset($body[$formClass]) to
         * detect if the input is submitted.
         * The hidden input will be assigned its own set of html options via `$hiddenOptions`.
         * This provides the possibility to interact with the hidden field via client script.
         *
         * Note: For file-field-only form with `disabled` option set to `true` input submitting detection won't work.
         */
        $hiddenInput = '';

        if ($new->withHiddenInput === true) {
            $hiddenInput = HiddenInput::widget()->config($new->data, $new->attribute, $hiddenOptions)->run();
        }

        $new->options['value'] = false;
        return
            $hiddenInput .
            Input::widget()
                ->type('file')
                ->config($new->data, $new->attribute, $new->options)
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
     * The accept attribute value is a string that defines the file types the file input should accept. This string is
     * a comma-separated list of unique file type specifiers. Because a given file type may be identified in more than
     * one manner, it's useful to provide a thorough set of type specifiers when you need files of a given format.
     *
     * @param string $value
     *
     * @return self
     */
    public function accept(string $value): self
    {
        $new = clone $this;
        $new->options['accept'] = $value;
        return $new;
    }

    /**
     * Focus on the control (put cursor into it) when the page loads.
     * Only one form element could be in focus at the same time.
     *
     * @param bool $value
     *
     * @return self
     */
    public function autofocus(bool $value = true): self
    {
        $new = clone $this;
        $new->options['autofocus'] = $value;
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
     * HiddenOptions parameter which is another set of HTML options array is defined, to be used for the hidden input.
     *
     * @param array $value
     *
     * @return self
     */
    public function hiddenOptions(array $value = []): self
    {
        $new = clone $this;
        $new->options['hiddenOptions'] = $value;
        $new->withHiddenInput = true;
        return $new;
    }

    /**
     * When the multiple Boolean attribute is specified, the file input allows the user to select more than one file.
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
     * If it is required to fill in a value in order to submit the form.
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
     * @return self
     */
    public function tabIndex(int $value = 0): self
    {
        $new = clone $this;
        $new->options['tabindex'] = $value;
        return $new;
    }

    /**
     * Allows you to disable hidden input widget.
     *
     * @param bool $value
     *
     * @return self
     */
    public function withHiddenInput(bool $value): self
    {
        $new = clone $this;
        $new->withHiddenInput = $value;
        return $new;
    }
}
