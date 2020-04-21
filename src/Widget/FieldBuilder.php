<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Factory\Exceptions\InvalidConfigException;
use Yiisoft\Form\Exception\InvalidArgumentException;
use Yiisoft\Form\FormInterface;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

use function array_merge;
use function is_subclass_of;

class FieldBuilder extends Widget
{
    use Collection\Options;
    use Collection\InputOptions;
    use Collection\HtmlForm;

    private ?FormBuilder $form = null;
    private string $template = "{label}\n{input}\n{hint}\n{error}";
    private array $divOptions = ['class' => 'form-group'];
    private array $errorOptions = ['class' => 'help-block'];
    private array $labelOptions = ['class' => 'control-label'];
    private array $hintOptions = ['class' => 'hint-block'];
    private ?bool $validateOnChange = null;
    private ?bool $validateOnBlur = null;
    private ?bool $validateOnType = null;
    private ?int $validationDelay = null;
    private array $selectors = [];
    private array $parts = [];
    private ?string $inputId = null;
    private bool $skipLabelFor = false;

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
        } elseif (!is_string($content)) {
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
        $attribute = Html::getAttributeName($this->attribute);
        $inputId = $this->getInputId();

        if ($this->data->isAttributeRequired($attribute)) {
            $class[] = $this->form->getRequiredCssClass();
        }

        $options['class'] = implode(' ', array_merge($this->divOptions, ["field-$inputId"]));

        if ($this->form->getValidationStateOn() === FormBuilder::VALIDATION_STATE_ON_CONTAINER) {
            $this->addErrorClassIfNeeded($options);
        }

        $tag = ArrayHelper::remove($options, 'tag', 'div');

        return Html::beginTag($tag, $options);
    }

    /**
     * Renders the closing tag of the field container.
     *
     * @return string the rendering result.
     */
    public function renderEnd(): string
    {
        $html = Html::endTag(ArrayHelper::keyExists($this->options, 'tag') ? $this->options['tag'] : 'div');

        return $html;
    }

    /**
     * Generates a label tag for {@see attribute}.
     *
     * @param string|null $label the label to use. If `null`, the label will be generated via
     * {@see FormBuilder::getAttributeLabel()}.
     * Note that this will NOT be {@see \Yiisoft\Html\Html::encode()|encoded}.
     * @param array $options the tag options in terms of name-value pairs. It will be merged with {@see labelOptions}.
     * The options will be rendered as the attributes of the resulting tag. The values will be HTML-encoded using
     * {@see \Yiisoft\Html\Html::encode()}. If a value is `null`, the corresponding attribute will not be rendered.
     *
     * @throws InvalidConfigException
     *
     * @return self the field object itself.
     */
    public function label(?string $label = null, array $options = []): self
    {
        if ($label === false) {
            $this->parts['{label}'] = '';

            return $this;
        }

        $options = array_merge($this->labelOptions, $options);

        if ($label !== null) {
            $options['label'] = $label;
        }

        if ($this->skipLabelFor) {
            $options['for'] = null;
        }

        $this->parts['{label}'] = Label::widget()
            ->data($this->data)
            ->attribute($this->attribute)
            ->options($options)
            ->run();

        return $this;
    }

    /**
     * Generates a tag that contains the first validation error of {@see attribute}.
     *
     * Note that even if there is no validation error, this method will still return an empty error tag.
     *
     * @param array $options the tag options in terms of name-value pairs. It will be merged with
     * {@see errorOptions}.
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
     * {@see $errorOptions}
     */
    public function error(array $options = []): self
    {
        if ($options) {
            $this->parts['{error}'] = '';

            return $this;
        }

        $options = array_merge($this->errorOptions, $options);

        $this->parts['{error}'] = Error::widget()
            ->data($this->data)
            ->attribute($this->attribute)
            ->options($options)
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

        $options = array_merge($this->hintOptions, $options);

        if ($content !== null) {
            $options['hint'] = $content;
        }

        $this->parts['{hint}'] = Hint::widget()
            ->data($this->data)
            ->attribute($this->attribute)
            ->options($options)
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
        $this->addAriaAttributes($options);
        $this->configInputOptions($options);
        $this->addInputCssClass($options);

        $options = array_merge($this->inputOptions, $options);

        if ($this->form->getValidationStateOn() === FormBuilder::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->parts['{input}'] = Input::widget()
            ->type($type)
            ->data($this->data)
            ->attribute($this->attribute)
            ->options($options)
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
        $this->configInputOptions($options);

        $this->addInputCssClass($options);

        $options = array_merge($this->inputOptions, $options);

        if ($this->form->getValidationStateOn() === FormBuilder::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->parts['{input}'] = TextInput::widget()
            ->data($this->data)
            ->attribute($this->attribute)
            ->options($options)
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
        $this->label(null);

        Html::addCssClass($options, $this->form->getInputCssClass());

        $options = array_merge($this->inputOptions, $options);

        $this->adjustLabelFor($options);

        $this->parts['{input}'] = HiddenInput::widget()
            ->data($this->data)
            ->attribute($this->attribute)
            ->options($options)
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
        $this->configInputOptions($options);

        Html::addCssClass($options, $this->form->getInputCssClass());

        $options = array_merge($this->inputOptions, $options);

        if ($this->form->getValidationStateOn() === FormBuilder::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->parts['{input}'] = PasswordInput::widget()
            ->data($this->data)
            ->attribute($this->attribute)
            ->options($options)
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
        $options = array_merge($this->inputOptions, $options);

        if (!isset($this->options['enctype'])) {
            $this->form->options(array_merge($this->options, ['enctype' => 'multipart/form-data']));
        }

        if ($this->form->getValidationStateOn() === FormBuilder::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);

        $this->parts['{input}'] = FileInput::widget()
            ->data($this->data)
            ->attribute($this->attribute)
            ->options($options)
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
        Html::addCssClass($options, $this->form->getInputCssClass());

        $options = array_merge($this->inputOptions, $options);

        if ($this->form->getValidationStateOn() === FormBuilder::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);

        $this->parts['{input}'] = TextArea::widget()
            ->data($this->data)
            ->attribute($this->attribute)
            ->options($options)
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
        if ($enclosedByLabel) {
            $this->parts['{input}'] = Radio::widget()
                ->data($this->data)
                ->attribute($this->attribute)
                ->options($options)
                ->run();
            $this->parts['{label}'] = '';
        } else {
            if (isset($options['label']) && !isset($this->parts['{label}'])) {
                $this->parts['{label}'] = $options['label'];
                if (!empty($options['labelOptions'])) {
                    $this->labelOptions = $options['labelOptions'];
                }
            }

            unset($options['labelOptions']);

            $options['label'] = null;
            $this->parts['{input}'] = Radio::widget()
                ->data($this->data)
                ->attribute($this->attribute)
                ->options($options)
                ->run();
        }

        if ($this->form->getValidationStateOn() === FormBuilder::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);

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
        $this->configInputOptions($options);

        if ($enclosedByLabel) {
            $this->parts['{input}'] = Checkbox::widget()
                ->data($this->data)
                ->attribute($this->attribute)
                ->options($options)
                ->run();
            $this->parts['{label}'] = '';
        } else {
            if (isset($options['label']) && !isset($this->parts['{label}'])) {
                $this->parts['{label}'] = $options['label'];
                if (!empty($options['labelOptions'])) {
                    $this->labelOptions = $options['labelOptions'];
                }
            }

            unset($options['labelOptions']);

            $options['label'] = null;
            $this->parts['{input}'] = Checkbox::widget()
                ->data($this->data)
                ->attribute($this->attribute)
                ->options($options)
                ->run();
        }

        if ($this->form->getValidationStateOn() === FormBuilder::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

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
        Html::addCssClass($options, $this->form->getInputCssClass());

        $options = array_merge($this->inputOptions, $options);

        if ($this->form->getValidationStateOn() === FormBuilder::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);

        $this->parts['{input}'] = DropDownList::widget()
            ->data($this->data)
            ->attribute($this->attribute)
            ->items($items)
            ->options($options)
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
        Html::addCssClass($options, $this->form->getInputCssClass());

        $options = array_merge($this->inputOptions, $options);

        if ($this->form->getValidationStateOn() === FormBuilder::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);

        $this->parts['{input}'] = ListBox::widget()
            ->data($this->data)
            ->attribute($this->attribute)
            ->items($items)
            ->options($options)
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
        if ($this->form->getValidationStateOn() === FormBuilder::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);

        $this->skipLabelFor = true;
        $this->parts['{input}'] = CheckboxList::widget()
            ->data($this->data)
            ->attribute($this->attribute)
            ->items($items)
            ->options($options)
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
        if ($this->form->getValidationStateOn() === FormBuilder::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);

        $this->skipLabelFor = true;
        $this->parts['{input}'] = RadioList::widget()
            ->data($this->data)
            ->attribute($this->attribute)
            ->items($items)
            ->options($options)
            ->run();

        return $this;
    }

    /**
     * Renders a widget as the input of the field.
     *
     * Note that the widget must have both `model` and `attribute` properties. They will be initialized with
     * {@see model} and [[attribute]] of this field, respectively.
     *
     * If you want to use a widget that does not have `model` and `attribute` properties, please use {@see render()}
     * instead.
     *
     * For example to use the {@see MaskedInput} widget to get some date input, you can use the following code,
     * assuming that `$forms` is your {@see FormBuilder} instance:
     *
     * ```php
     * $form->field($model, 'date')->widget(\Yiisoft\Yii\MaskedInput\MaskedInput::class, [
     *     'mask' => '99/99/9999',
     * ]);
     * ```
     *
     * If you set a custom `id` for the input element, you may need to adjust the {@see $selectors} accordingly.
     *
     * @param string $class  the widget class name.
     * @param array $config name-value pairs that will be used to initialize the widget.
     *
     * @throws \Exception
     *
     * @return self the field object itself.
     */
    public function renderWidget(string $class, array $config = []): self
    {
        $config['model'] = $this->data;
        $config['attribute'] = $this->attribute;
        $config['view'] = $this->form->getView();

        if (is_subclass_of($class, InputWidget::class, true)) {
            $config['field'] = $this;

            if (isset($config['options'])) {
                if ($this->form->getValidationStateOn() === FormBuilder::VALIDATION_STATE_ON_INPUT) {
                    $this->addErrorClassIfNeeded($config['options']);
                }

                $this->addAriaAttributes($config['options']);
                $this->adjustLabelFor($config['options']);
            }
        }

        $this->parts['{input}'] = $class::widget($config);

        return $this;
    }

    /**
     * Returns the HTML `id` of the input element of this form field.
     *
     * @throws InvalidArgumentException
     *
     * @return string the input id.
     */
    public function getInputId(): string
    {
        return $this->inputId ?: $this->addInputId($this->data, $this->attribute);
    }

    /**
     * Adds validation class to the input options if needed.
     *
     * @param array $options array input options
     *
     * @throws InvalidArgumentException
     */
    protected function addErrorClassIfNeeded(array &$options = []): void
    {
        $attributeName = $this->getAttributeName($this->attribute);

        if ($this->data->hasErrors($attributeName)) {
            Html::addCssClass($options, $this->form->getErrorCssClass());
        }
    }

    /**
     * @param FormBuilder $value the form that this field is associated with.
     *
     * @return self
     */
    public function form(FormBuilder $value): self
    {
        $this->form = $value;

        return $this;
    }

    /**
     * @param string $value the template that is used to arrange the label, the input field, the error message and the
     * hint text. The following tokens will be replaced when {@see render()} is called: `{label}`, `{input}`, `{error}`
     * and `{hint}`.
     *
     * @return self
     */
    public function template(string $value): self
    {
        $this->template = $value;

        return $this;
    }

    /**
     * @param array $value the default options for the error tags. The parameter passed to [[error()]] will be merged
     * with this property when rendering the error tag.
     *
     * The following special options are recognized:
     *
     * - `tag`: the tag name of the container element. Defaults to `div`. Setting it to `false` will not render a
     * container tag. {@see \Yiisoft\Html\Html::tag()}.
     * - `encode`: whether to encode the error output. Defaults to `true`.
     *
     * If you set a custom `id` for the error element, you may need to adjust the {@see $selectors} accordingly.
     *
     * @return self
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function errorOptions(array $value): self
    {
        $this->errorOptions = $value;

        return $this;
    }

    /**
     * @param array $value the default options for the label tags. The parameter passed to {@see label()} will be
     * merged with this property when rendering the label tag.
     *
     * @return self
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function labelOptions(array $value): self
    {
        $this->labelOptions = $value;

        return $this;
    }

    /**
     * @param array $value the default options for the hint tags. The parameter passed to {@see hint()} will be merged
     * with this property when rendering the hint tag.
     * The following special options are recognized:
     *
     * - `tag`: the tag name of the container element. Defaults to `div`. Setting it to `false` will not render a
     * container tag. {@see \Yiisoft\Html\Html::tag()}.
     *
     * @return self
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function hintOptions(array $value): self
    {
        $this->hintOptions = $value;

        return $this;
    }

    /**
     * @param bool $value whether to perform validation when the value of the input field is changed.
     * If not set, it will take the value of {@see FormBuilder::validateOnChange}.
     *
     * @return self
     */
    public function validateOnChange(bool $value): self
    {
        $this->validateOnChange = $value;

        return $this;
    }

    /**
     * @param bool $value whether to perform validation when the input field loses focus.
     * If not set, it will take the value of {@see FormBuilder::validateOnBlur}.
     *
     * @return self
     */
    public function validateOnBlur(bool $value): self
    {
        $this->validateOnBlur = $value;

        return $this;
    }

    /**
     * @param bool $value whether to perform validation while the user is typing in the input field.
     * If not set, it will take the value of {@see FormBuilder::validateOnType}.
     *
     * @return self
     */
    public function validateOnType(bool $value): self
    {
        $this->validateOnType = $value;

        return $this;
    }

    /**
     * @param int number of milliseconds that the validation should be delayed when the user types in the field and
     * {@see validateOnType] is set `true`.
     * If not set, it will take the value of {@see FormBuilder::validationDelay}.
     *
     * @return self
     */
    public function validationDelay(int $value): self
    {
        $this->validationDelay = $value;

        return $this;
    }

    /**
     * @param array $value the jQuery selectors for selecting the container, input and error tags.
     * The array keys should be `container`, `input`, and/or `error`, and the array values are the corresponding
     * selectors. For example, `['input' => '#my-input']`.
     *
     * The container selector is used under the context of the form, while the input and the error selectors are used
     * under the context of the container.
     *
     * You normally do not need to set this property as the default selectors should work well for most cases.
     *
     * @return self
     */
    public function selectors(array $value): self
    {
        $this->selectors = $value;

        return $this;
    }

    /**
     * @param array $value different parts of the field (e.g. input, label). This will be used together with
     * {@see template} to generate the final field HTML code. The keys are the token names in {@see template}, while
     * the values are the corresponding HTML code. Valid tokens include `{input}`, `{label}` and `{error}`. Note that
     * you normally don't need to access this property directly as it is maintained by various methods of this class.
     *
     * @return self
     */
    public function parts(array $value): self
    {
        $this->parts = $value;

        return $this;
    }

    /**
     * @param string this property holds a custom input id if it was set using {@see inputOptions} or in one of the
     * `$options` parameters of the `input*` methods.
     *
     * @return self
     */
    public function inputId(string $value): self
    {
        $this->inputId = $value;

        return $this;
    }

    /**
     * @param bool $value if "for" field label attribute should be skipped.
     *
     * @return self
     */
    public function skipLabelFor(bool $value): self
    {
        $this->skipLabelFor = $value;

        return $this;
    }

    private function addInputCssClass($options): void
    {
        if (!isset($options['class'])) {
            Html::addCssClass($this->inputOptions, $this->form->getInputCssClass());
        } elseif ($options['class'] !== 'form-control') {
            Html::addCssClass($this->inputOptions, $this->form->getInputCssClass());
        }
    }

    /**
     * Adds aria attributes to the input options.
     *
     * @param array $options array input options
     */
    private function addAriaAttributes(array $options = []): void
    {
        if ($this->ariaAttribute && ($this->data instanceof FormInterface)) {
            if (!isset($options['aria-required']) && $this->data->isAttributeRequired($this->attribute)) {
                $this->inputOptions['aria-required'] = 'true';
            }

            if (!isset($options['aria-invalid']) && $this->data->hasErrors($this->attribute)) {
                $this->inputOptions['aria-invalid'] = 'true';
            }
        }
    }
}
