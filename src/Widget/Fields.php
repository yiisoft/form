<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

use function array_merge;

class Fields extends Widget implements FieldsInterface
{
    use Collection\FieldsOptions;

    public const DIV_CSS = ['class' => 'form-group'];
    public const ERROR_CSS = ['class' => 'help-block'];
    public const HINT_CSS = ['class' => 'hint-block'];
    public const LABEL_CSS = ['class' => 'control-label'];

    /**
     * Renders the whole field.
     *
     * This method will generate the label, error tag, input tag and hint tag (if any), and assemble them into HTML
     * according to {@see template}.
     *
     * @param string|null $content the content within the field container.
     *
     * If `null` (not set), the default methods will be called to generate the label, error tag and input tag, and use
     * them as the content.
     *
     * @throws InvalidConfigException
     *
     * @return string the rendering result.
     */
    public function run(?string $content = null): string
    {
        if ($content === null) {
            if (!isset($this->parts['{input}'])) {
                $this->textInput();
            }

            if (!isset($this->parts['{label}'])) {
                $this->label();
            }

            if (!isset($this->parts['{error}'])) {
                $this->error();
            }

            if (!isset($this->parts['{hint}'])) {
                $this->hint();
            }

            $content = strtr($this->template, $this->parts);
        } else {
            $content = $content($this);
        }

        return $this->renderBegin() . "\n" . $content . "\n" . $this->renderEnd();
    }

    /**
     * Renders the opening tag of the field container.
     *
     * @throws InvalidArgumentException
     *
     * @return string the rendering result.
     */
    public function renderBegin(): string
    {
        $new = clone $this;

        $inputId = $new->addInputId();

        $class = [];
        $class[] = "field-$inputId";
        $class[] = $new->options['class'] ?? '';

        $new->options['class'] = trim(implode(' ', array_merge($new::DIV_CSS, $class)));

        $new->addErrorCssContainer($new);

        $tag = ArrayHelper::remove($new->options, 'tag', 'div');

        return Html::beginTag($tag, $new->options);
    }

    /**
     * Renders the closing tag of the field container.
     *
     * @return string the rendering result.
     */
    public function renderEnd(): string
    {
        return Html::endTag(ArrayHelper::keyExists($this->options, 'tag') ? $this->options['tag'] : 'div');
    }

    /**
     * Generates a label tag for {@see attribute}.
     *
     * @param bool $enabledLabel enabled/disable <label>.
     * @param array $options the tag options in terms of name-value pairs. It will be merged with {@see labelOptions}.
     * The options will be rendered as the attributes of the resulting tag. The values will be HTML-encoded using
     * {@see \Yiisoft\Html\Html::encode()}. If a value is `null`, the corresponding attribute will not be rendered.
     * @param string|null $label the label to use. If `null`, the label will be generated via
     * {@see FormBuilder::getAttributeLabel()}.
     * Note that this will NOT be {@see \Yiisoft\Html\Html::encode()|encoded}.
     *
     * @throws InvalidConfigException
     *
     * @return self the field object itself.
     */
    public function label(bool $enabledLabel = false, array $options = [], string $label = ''): self
    {
        if ($enabledLabel === false) {
            $this->parts['{label}'] = '';

            return $this;
        }

        $new = clone $this;

        $new->inputOptions['label'] = !empty($label) ? $label : Html::getAttributeName($new->attribute);

        $new->addLabelCss($new, $options);
        $new->addSkipLabelFor($new);

        unset($options['class']);

        $new->inputOptions = array_merge($new->inputOptions, $options);

        $this->parts['{label}'] = Label::widget()
            ->config($new->data, $new->attribute, $new->inputOptions)
            ->run();

        return $this;
    }

    /**
     * Generates a tag that contains the first validation error of {@see attribute}.
     *
     * Note that even if there is no validation error, this method will still return an empty error tag.
     *
     * @param array $options the tag options in terms of name-value pairs. It will be merged with
     * {@see ERROR_CSS}.
     * The options will be rendered as the attributes of the resulting tag. The values will be HTML-encoded using
     * {@see \Yiisoft\Html\Html::encode()}. If this parameter is `false`, no error tag will be rendered.
     *
     * The following options are specially handled:
     *
     * - `tag`: this specifies the tag name. If not set, `div` will be used. See also {@see \Yiisoft\Html\Html::tag()}.
     *
     * If you set a custom `id` for the error element, you may need to adjust the {@see $selectors} accordingly.
     *
     * @throws InvalidConfigException
     *
     * @return self the field object itself.
     *
     * {@see ERROR_CSS}
     */
    public function error(array $options = []): self
    {
        $new = clone $this;

        $new->addErrorCss($new, $options);

        unset($options['class']);

        $new->inputOptions = array_merge($new->inputOptions, $options);

        $this->parts['{error}'] = Error::widget()
            ->config($new->data, $new->attribute, $new->inputOptions)
            ->run();

        return $this;
    }

    /**
     * Renders the hint tag.
     *
     * @param string|null $content the hint content. If `null`, the hint will be generated via
     * {@see Form::getAttributeHint()}.
     * @param bool $typeHint If `false`, the generated field will not contain the hint part. Note that this will NOT be
     * {@see \Yiisoft\Html\Html::encode()|encoded}.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as the attributes of
     * the hint tag. The values will be HTML-encoded using {@see \Yiisoft\Html\Html::encode()}.
     *
     * The following options are specially handled:
     *
     * - `tag`: this specifies the tag name. If not set, `div` will be used. See also {@see \Yiisoft\Html\Html::tag()}.
     *
     * @throws InvalidConfigException
     *
     * @return self the field object itself.
     */
    public function hint(?string $content = null, bool $typeHint = true, array $options = []): self
    {
        if ($typeHint === false) {
            $this->parts['{hint}'] = '';

            return $this;
        }

        $new = clone $this;

        $new->addHintCss($new, $options);

        unset($options['class']);

        if ($content !== null) {
            $new->inputOptions['hint'] = $content;
        }

        $new->inputOptions = array_merge($new->inputOptions, $options);

        $this->parts['{hint}'] = Hint::widget()
            ->config($new->data, $new->attribute, $new->inputOptions)
            ->run();

        return $this;
    }

    /**
     * Renders an input tag.
     *
     * @param string $type the input type (e.g. `text`, `password`).
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as the attributes of
     * the resulting tag. The values will be HTML-encoded using {@see \Yiisoft\Html\Html::encode()}.
     *
     * If you set a custom `id` for the input element, you may need to adjust the {@see $selectors} accordingly.
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     *
     * @return self the field object itself.
     */
    public function input(string $type, array $options = []): self
    {
        $new = clone $this;

        $new->addAriaAttributes($new, $options);
        $new->addInputCss($new, $options);
        $new->addErrorCssInput($new);

        unset($options['class']);

        $new->inputOptions = array_merge($options, $new->inputOptions);

        $this->parts['{input}'] = Input::widget()
            ->type($type)
            ->config($new->data, $new->attribute, $new->inputOptions)
            ->run();

        return $this;
    }

    /**
     * Renders a text input.
     *
     * This method will generate the `name` and `value` tag attributes automatically for the model attribute unless
     * they are explicitly specified in `$options`.
     *
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as the attributes
     * of the resulting tag. The values will be HTML-encoded using {@see \Yiisoft\Html\Html::encode()}.
     *
     * The following special options are recognized:
     *
     * Note that if you set a custom `id` for the input element, you may need to adjust the value of {@see selectors}
     * accordingly.
     *
     * @throws InvalidConfigException
     *
     * @return self the field object itself.
     */
    public function textInput(array $options = []): self
    {
        $new = clone $this;

        $new->addAriaAttributes($new, $options);
        $new->addInputCss($new, $options);
        $new->addErrorCssInput($new);

        unset($options['class']);

        $new->inputOptions = array_merge($options, $new->inputOptions);

        $this->parts['{input}'] = TextInput::widget()
            ->config($new->data, $new->attribute, $new->inputOptions)
            ->run();

        return $this;
    }

    /**
     * Renders a hidden input.
     *
     * Note that this method is provided for completeness. In most cases because you do not need to validate a hidden
     * input, you should not need to use this method. Instead, you should use
     * {@see \Yiisoft\Html\Html::activeHiddenInput()}.
     *
     * This method will generate the `name` and `value` tag attributes automatically for the model attribute unless
     * they are explicitly specified in `$options`.
     *
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as the attributes of
     * the resulting tag. The values will be HTML-encoded using {@see \Yiisoft\Html\Html::encode()}.
     *
     * If you set a custom `id` for the input element, you may need to adjust the {@see $selectors} accordingly.
     *
     * @throws InvalidConfigException
     *
     * @return self the field object itself.
     */
    public function hiddenInput(array $options = []): self
    {
        $new = clone $this;

        $new->addInputCss($new, $options);

        unset($options['class']);

        $new->inputOptions = array_merge($options, $new->inputOptions);

        $this->parts['{input}'] = HiddenInput::widget()
            ->config($new->data, $new->attribute, $new->inputOptions)
            ->run();

        return $this;
    }

    /**
     * Renders a password input.
     *
     * This method will generate the `name` and `value` tag attributes automatically for the model attribute unless
     * they are explicitly specified in `$options`.
     *
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as the attributes of
     * the resulting tag. The values will be HTML-encoded using {@see \Yiisoft\Html\Html::encode()}.
     *
     * If you set a custom `id` for the input element, you may need to adjust the {@see $selectors} accordingly.
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     *
     * @return self the field object itself.
     */
    public function passwordInput(array $options = []): self
    {
        $new = clone $this;

        $new->addAriaAttributes($new, $options);
        $new->addInputCss($new, $options);
        $new->addErrorCssInput($new);

        unset($options['class']);

        $new->inputOptions = array_merge($options, $new->inputOptions);

        $this->parts['{input}'] = PasswordInput::widget()
            ->config($new->data, $new->attribute, $new->inputOptions)
            ->run();

        return $this;
    }

    /**
     * Renders a file input.
     *
     * This method will generate the `name` and `value` tag attributes automatically for the model attribute unless
     * they are explicitly specified in `$options`.
     *
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as the attributes of
     * the resulting tag. The values will be HTML-encoded using {@see \Yiisoft\Html\Html::encode()}.
     *
     * If you set a custom `id` for the input element, you may need to adjust the {@see $selectors} accordingly.
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     *
     * @return self the field object itself.
     */
    public function fileInput(array $options = []): self
    {
        $new = clone $this;

        if (!isset($options['enctype'])) {
            $new->inputOptions['enctype'] = 'multipart/form-data';
        }

        $new->addAriaAttributes($new, $options);
        $new->addErrorCssInput($new);
        $new->addInputCss($new, $options);
        $new->adjustLabelFor($new, $options);

        unset($options['class']);

        $new->inputOptions = array_merge($options, $new->inputOptions);

        $this->parts['{input}'] = FileInput::widget()
            ->config($new->data, $new->attribute, $new->inputOptions)
            ->run();

        return $this;
    }

    /**
     * Renders a text area.
     *
     * The model attribute value will be used as the content in the textarea.
     *
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as the attributes of
     * the resulting tag. The values will be HTML-encoded using {@see \Yiisoft\Html\Html::encode()}.
     *
     * If you set a custom `id` for the textarea element, you may need to adjust the {@see $selectors} accordingly.
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     *
     * @return self the field object itself.
     */
    public function textArea(array $options = []): self
    {
        $new = clone $this;

        $new->addAriaAttributes($new, $options);
        $new->addInputCss($new, $options);
        $new->addErrorCssInput($new);

        unset($options['class']);

        $new->inputOptions = array_merge($options, $new->inputOptions);

        $this->parts['{input}'] = TextArea::widget()
            ->config($new->data, $new->attribute, $new->inputOptions)
            ->run();

        return $this;
    }

    /**
     * Renders a radio button.
     *
     * This method will generate the `checked` tag attribute according to the model attribute value.
     *
     * @param array $options the tag options in terms of name-value pairs. The following options are specially handled:
     *
     * - `uncheck`: string, the value associated with the uncheck state of the radio button. If not set, it will take
     * the default value `0`. This method will render a hidden input so that if the radio button is not checked and is
     * submitted, the value of this attribute will still be submitted to the server via the hidden input. If you do not
     * want any hidden input, you should explicitly set this option as `null`.
     * - `label`: string, a label displayed next to the radio button. It will NOT be HTML-encoded. Therefore you can
     * pass in HTML code such as an image tag. If this is coming from end users, you should
     * {@see \Yiisoft\Html\Html::encode()|encode} it to prevent XSS attacks.
     * When this option is specified, the radio button will be enclosed by a label tag. If you do not want any label,
     * you should explicitly set this option as `null`.
     * - `labelOptions`: array, the HTML attributes for the label tag. This is only used when the `label` option is
     * specified.
     *
     * The rest of the options will be rendered as the attributes of the resulting tag. The values will be HTML-encoded
     * using {@see \Yiisoft\Html\Html::encode()}. If a value is `null`, the corresponding attribute will not be
     * rendered.
     *
     * If you set a custom `id` for the input element, you may need to adjust the {@see $selectors} accordingly.
     * @param bool $enclosedByLabel whether to enclose the radio within the label.
     * If `true`, the method will still use {@see template} to layout the radio button and the error message except
     * that the radio is enclosed by the label tag.
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     *
     * @return self the field object itself.
     */
    public function radio(array $options = [], bool $enclosedByLabel = true): self
    {
        $new = clone $this;

        if ($enclosedByLabel) {
            $this->parts['{input}'] = Radio::widget()
                ->config($new->data, $new->attribute, $options)
                ->addLabel(true)
                ->run();
            $this->parts['{label}'] = '';
        } else {
            if (isset($options['label']) && !isset($this->parts['{label}'])) {
                $this->parts['{label}'] = $options['label'];
                if (!empty($options['labelOptions'])) {
                    $new->labelOptions = $options['labelOptions'];
                }
            }

            unset($options['labelOptions']);

            $this->parts['{input}'] = Radio::widget()
                ->config($new->data, $new->attribute, $options)
                ->run();
        }

        $new->addAriaAttributes($new, $options);
        $new->addErrorCssInput($new);

        return $this;
    }

    /**
     * Renders a checkbox.
     *
     * This method will generate the `checked` tag attribute according to the model attribute value.
     *
     * @param array $options the tag options in terms of name-value pairs. The following options are specially handled:
     *
     * - `uncheck`: string, the value associated with the uncheck state of the radio button. If not set, it will take
     * the default value `0`. This method will render a hidden input so that if the radio button is not checked and is
     * submitted, the value of this attribute will still be submitted to the server via the hidden input. If you do not
     * want any hidden input, you should explicitly set this option as `null`.
     * - `label`: string, a label displayed next to the checkbox. It will NOT be HTML-encoded. Therefore you can pass
     * in HTML code such as an image tag. If this is coming from end users, you should
     * {@see \Yiisoft\Html\Html::encode()|encode} it to prevent XSS attacks.
     * When this option is specified, the checkbox will be enclosed by a label tag. If you do not want any label, you
     * should explicitly set this option as `null`.
     * - `labelOptions`: array, the HTML attributes for the label tag. This is only used when the `label` option is
     * specified.
     *
     * The rest of the options will be rendered as the attributes of the resulting tag. The values will be HTML-encoded
     * using {@see \Yiisoft\Html\Html::encode()}. If a value is `null`, the corresponding attribute will not be
     * rendered.
     *
     * If you set a custom `id` for the input element, you may need to adjust the {@see $selectors} accordingly.
     * @param bool $enclosedByLabel whether to enclose the checkbox within the label.
     * If `true`, the method will still use [[template]] to layout the checkbox and the error message except that the
     * checkbox is enclosed by the label tag.
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     *
     * @return self the field object itself.
     */
    public function checkbox(array $options = [], bool $enclosedByLabel = true): self
    {
        $new = clone $this;

        if ($enclosedByLabel) {
            $this->parts['{input}'] = CheckBox::widget()
                ->config($new->data, $new->attribute, $options)
                ->addLabel(true)
                ->run();
            $this->parts['{label}'] = '';
        } else {
            if (isset($options['label']) && !isset($this->parts['{label}'])) {
                $this->parts['{label}'] = $options['label'];
                if (!empty($options['labelOptions'])) {
                    $new->labelOptions = $options['labelOptions'];
                }
            }

            unset($options['labelOptions']);

            $this->parts['{input}'] = CheckBox::widget()
                ->config($new->data, $new->attribute, $options)
                ->run();
        }

        $new->addErrorCssInput($new);

        return $this;
    }

    /**
     * Renders a drop-down list.
     *
     * The selection of the drop-down list is taken from the value of the model attribute.
     *
     * @param array $items the option data items. The array keys are option values, and the array values are the
     * corresponding option labels. The array can also be nested (i.e. some array values are arrays too).
     * For each sub-array, an option group will be generated whose label is the key associated with the sub-array.
     * If you have a list of data models, you may convert them into the format described above using
     * {@see \Yiisoft\Arrays\ArrayHelper::map()}.
     *
     * Note, the values and labels will be automatically HTML-encoded by this method, and the blank spaces in the
     * labels will also be HTML-encoded.
     * @param array $options the tag options in terms of name-value pairs.
     *
     * For the list of available options please refer to the `$options` parameter of
     * {@see \Yiisoft\Html\Html::activeDropDownList()}.
     *
     * If you set a custom `id` for the input element, you may need to adjust the {@see $selectors} accordingly.
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     *
     * @return self the field object itself.
     */
    public function dropDownList(array $items, array $options = []): self
    {
        $new = clone $this;

        $new->addAriaAttributes($new, $options);
        $new->addInputCss($new, $options);
        $new->addErrorCssInput($new);

        unset($options['class']);

        $new->inputOptions = array_merge($options, $new->inputOptions);

        $this->parts['{input}'] = DropDownList::widget()
            ->config($new->data, $new->attribute, $new->inputOptions)
            ->items($items)
            ->run();

        return $this;
    }

    /**
     * Renders a list box.
     *
     * The selection of the list box is taken from the value of the model attribute.
     *
     * @param array $items the option data items. The array keys are option values, and the array values are the
     * corresponding option labels. The array can also be nested (i.e. some array values are arrays too).
     * For each sub-array, an option group will be generated whose label is the key associated with the sub-array.
     * If you have a list of data models, you may convert them into the format described above using
     * {@see \Yiisoft\Arrays\ArrayHelper::map()}.
     *
     * Note, the values and labels will be automatically HTML-encoded by this method, and the blank spaces in the
     * labels will also be HTML-encoded.
     * @param array $options the tag options in terms of name-value pairs.
     *
     * For the list of available options please refer to the `$options` parameter of
     * {@see \Yiisoft\Html\Html::activeListBox()}.
     *
     * If you set a custom `id` for the input element, you may need to adjust the {@see $selectors} accordingly.
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     *
     * @return self the field object itself.
     */
    public function listBox(array $items, array $options = []): self
    {
        $new = clone $this;

        $new->addAriaAttributes($new, $options);
        $new->adjustLabelFor($new, $options);

        $new->inputOptions = array_merge($options, $new->inputOptions);

        $this->parts['{input}'] = ListBox::widget()
            ->config($new->data, $new->attribute, $new->inputOptions)
            ->items($items)
            ->run();

        return $this;
    }

    /**
     * Renders a list of checkboxes.
     *
     * A checkbox list allows multiple selection, like {@see listBox()}.
     * As a result, the corresponding submitted value is an array.
     * The selection of the checkbox list is taken from the value of the model attribute.
     *
     * @param array $items the data item used to generate the checkboxes.
     * The array values are the labels, while the array keys are the corresponding checkbox values.
     * @param array $options options (name => config) for the checkbox list.
     * For the list of available options please refer to the `$options` parameter of
     * {@see \Yiisoft\Html\Html::activeCheckboxList()}.
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     *
     * @return self the field object itself.
     */
    public function checkboxList(array $items, array $options = []): self
    {
        $new = clone $this;

        $new->addAriaAttributes($new, $options);
        $new->adjustLabelFor($new, $options);

        $new->inputOptions = array_merge($options, $new->inputOptions);
        $new->skipLabelFor = true;

        $this->parts['{input}'] = CheckBoxList::widget()
            ->config($new->data, $new->attribute, $new->inputOptions)
            ->items($items)
            ->run();

        return $this;
    }

    /**
     * Renders a list of radio buttons.
     *
     * A radio button list is like a checkbox list, except that it only allows single selection.
     * The selection of the radio buttons is taken from the value of the model attribute.
     *
     * @param array $items the data item used to generate the radio buttons.
     * The array values are the labels, while the array keys are the corresponding radio values.
     * @param array $options options (name => config) for the radio button list.
     * For the list of available options please refer to the `$options` parameter of
     * {@see \Yiisoft\Html\Html::activeRadioList()}.
     *
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     *
     * @return self the field object itself.
     */
    public function radioList(array $items, array $options = []): self
    {
        $new = clone $this;

        $new->addAriaAttributes($new, $options);
        $new->adjustLabelFor($new, $options);
        $new->addInputCss($new, $options);
        $new->addErrorCssInput($new);
        $new->addRoleAttributes($new, $options);

        $new->inputOptions = array_merge($options, $new->inputOptions);

        $new->skipLabelFor = true;

        $this->parts['{input}'] = RadioList::widget()
            ->config($new->data, $new->attribute, $new->inputOptions)
            ->items($items)
            ->run();

        return $this;
    }

    public function addInputId(): string
    {
        return $this->inputId ?: HtmlForm::getInputId($this->data, $this->attribute);
    }
}
