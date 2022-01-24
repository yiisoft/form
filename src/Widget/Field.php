<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\Attribute\ButtonAttributes;
use Yiisoft\Form\Widget\Attribute\FieldAttributes;
use Yiisoft\Form\Widget\Attribute\InputAttributes;
use Yiisoft\Form\Widget\Attribute\GlobalAttributes;
use Yiisoft\Form\Widget\Attribute\PlaceholderInterface;
use Yiisoft\Form\Widget\Attribute\WidgetAttributes;
use Yiisoft\Form\Widget\FieldPart\Error;
use Yiisoft\Form\Widget\FieldPart\Hint;
use Yiisoft\Form\Widget\FieldPart\Label;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Div;

use function strtr;

/**
 * Renders the field widget along with label and hint tag (if any) according to template.
 *
 * @psalm-suppress MissingConstructor
 */
final class Field extends FieldAttributes
{
    private ButtonAttributes $button;
    private array $parts = [];
    private WidgetAttributes $inputWidget;
    private GlobalAttributes $widget;

    /**
     * Renders a button group widget.
     *
     * @param array $buttons List of buttons. Each array element represents a single button which can be specified as a
     * string or an array of the following structure:
     * - label: string, required, the button label.
     * - attributes: array, optional, the HTML attributes of the button.
     * - type: string, optional, the button type.
     * - visible: bool, optional, whether this button is visible. Defaults to true.
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field object itself.
     *
     * @psalm-param array<string, array|string> $buttons
     */
    public function buttonGroup(array $buttons, array $config = [], array $attributes = []): self
    {
        $new = clone $this;
        $new = $new->type('buttonGroup');
        $config = array_merge($new->getDefinitions(), $config);
        $new->button = ButtonGroup::widget($config)->attributes($attributes)->buttons($buttons);
        return $new;
    }

    /**
     * Renders a checkbox.
     *
     * This method will generate the `checked` tag attribute according to the model attribute value.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config The configuration array for widget factory.
     * Available methods:
     * [
     *     'enclosedByLabel()' => [false],
     *     'label()' => ['test-text-label'],
     *     'labelAttributes()' => [['class' => 'test-class']],
     *     'uncheckValue()' => ['0'],
     * ]
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field widget instance.
     */
    public function checkbox(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new = $new->type('checkbox');
        $config = array_merge($new->getDefinitions(), $config);

        /** @var array */
        $enclosedByLabel = $config['enclosedByLabel()'] ?? [true];

        if ($enclosedByLabel === [true]) {
            $new->parts['{label}'] = '';
        }

        $new->inputWidget = Checkbox::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a list of checkboxes.
     *
     * A checkbox list allows multiple selection, As a result, the corresponding submitted value is an array.
     *
     * The selection of the checkbox list is taken from the value of the model attribute.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config the configuration array for widget factory.
     * Available methods:
     * [
     *     'containerAttributes()' => [['class' => 'test-class']],
     *     'containerTag()' => ['span'],
     *     'individualItemsAttributes()' => [[1 => ['disabled' => true], 2 => ['class' => 'test-class']],
     *     'items()' => [[1 => 'Female', 2 => 'Male']],
     *     'itemsAttributes()' => [['disabled' => true],
     *     'itemsFormatter()' => [
     *         static function (CheckboxItem $item) {
     *             return $item->checked
     *                 ? "<label><input type='checkbox' name='$item->name' value='$item->value' checked> $item->label</label>"
     *                 : "<label><input type='checkbox' name='$item->name' value='$item->value'> $item->label</label>";
     *         },
     *     ],
     *     'itemsFromValues()' => [[1 => 'Female', 2 => 'Male']],
     *     'separator()' => ['&#9866;'],
     * ]
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field widget instance.
     */
    public function checkboxList(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new = $new->type('checkboxList');
        $config = array_merge($new->getDefinitions(), $config);
        $new->inputWidget = CheckboxList::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a date widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config the configuration array for widget factory.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field widget instance.
     */
    public function date(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new = $new->type('date');
        $config = array_merge($new->getDefinitions(), $config);
        $new->inputWidget = Date::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a date time widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config the configuration array for widget factory.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field widget instance.
     */
    public function dateTime(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new = $new->type('dateTime');
        $config = array_merge($new->getDefinitions(), $config);
        $new->inputWidget = DateTime::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a date time local widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config the configuration array for widget factory.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field widget instance.
     */
    public function dateTimeLocal(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new = $new->type('dateTimeLocal');
        $config = array_merge($new->getDefinitions(), $config);
        $new->inputWidget = DateTimeLocal::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a email widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config the configuration array for widget factory.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field widget instance.
     */
    public function email(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new = $new->type('email');
        $config = array_merge($new->getDefinitions(), $config);
        $new->inputWidget = Email::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a file widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config the configuration array for widget factory.
     * Available methods:
     * [
     *     'hiddenAttributes()' => [['id' => 'test-id']],
     *     'uncheckValue()' => ['0'],
     *
     * ]
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field widget instance.
     */
    public function file(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new = $new->type('file');
        $config = array_merge($new->getDefinitions(), $config);
        $new->inputWidget = File::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a hidden widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config the configuration array for widget factory.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field widget instance.
     */
    public function hidden(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new = $new->type('hidden');
        $new->parts['{label}'] = '';
        $new->parts['{hint}'] = '';
        $new->parts['{error}'] = '';
        $config = array_merge($new->getDefinitions(), $config);
        $new->inputWidget = Hidden::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders an image widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     * Most used attributes:
     * [
     *     'alt' => 'test-alt',
     *     'height' => '100%',
     *     'src' => 'test-src',
     *     'width' => '100%',
     * ]
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field object itself.
     */
    public function image(array $config = [], array $attributes = []): self
    {
        $new = clone $this;
        $new = $new->type('image');
        $new->parts['{label}'] = '';
        $new->parts['{hint}'] = '';
        $new->parts['{error}'] = '';
        $config = array_merge($new->getDefinitions(), $config);
        $new->widget = Image::widget($config)->attributes($attributes);
        return $new;
    }

    /**
     * Renders a number widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config the configuration array for widget factory.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field object itself.
     */
    public function number(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new = $new->type('number');
        $config = array_merge($new->getDefinitions(), $config);
        $new->inputWidget = Number::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a password widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config the configuration array for widget factory.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field object itself.
     */
    public function password(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new = $new->type('password');
        $config = array_merge($new->getDefinitions(), $config);
        $new->inputWidget = Password::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a radio widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config the configuration array for widget factory.
     * Available methods:
     * [
     *     'enclosedByLabel()' => [false],
     *     'label()' => ['Email:'],
     *     'labelAttributes()' => [['class' => 'test-class']]
     *     'uncheckValue()' => ['0'],
     * ]
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field object itself.
     */
    public function radio(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new = $new->type('radio');
        $config = array_merge($new->getDefinitions(), $config);

        /** @var array */
        $enclosedByLabel = $config['enclosedByLabel()'] ?? [true];

        if ($enclosedByLabel === [true]) {
            $new->parts['{label}'] = '';
        }

        $new->inputWidget = Radio::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a radio list widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config the configuration array for widget factory.
     * Available methods:
     * [
     *     'containerAttributes()' => [['class' => 'test-class']],
     *     'containerTag()' => ['span'],
     *     'items()' => [[1 => 'Female', 2 => 'Male']],
     *     'itemsAttributes()' => [['class' => 'test-class']],
     *     'individualItemsAttributes()' => [[1 => ['disabled' => true], 2 => ['class' => 'test-class']]],
     *     'itemsFormatter()' => [
     *         static function (RadioItem $item) {
     *             return $item->checked
     *                 ? "<label><input type='checkbox' name='$item->name' value='$item->value' checked> $item->label</label>"
     *                 : "<label><input type='checkbox' name='$item->name' value='$item->value'> $item->label</label>";
     *         },
     *     ],
     *     'itemsFromValues()' => [[1 => 'Female', 2 => 'Male']],
     *     'separator()' => [PHP_EOL],
     *     'uncheckValue()' => ['0'],
     * ]
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field object itself.
     */
    public function radioList(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new = $new->type('radioList');
        $config = array_merge($new->getDefinitions(), $config);
        $new->inputWidget = RadioList::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a range widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config the configuration array for widget factory.
     * Available methods:
     * [
     *     'outputTag()' => ['p'],
     *     'outputAttributes()' => [['class' => 'test-class']],
     * ]
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field object itself.
     */
    public function range(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new = $new->type('range');
        $config = array_merge($new->getDefinitions(), $config);
        $new->inputWidget = Range::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a reset button widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field object itself.
     */
    public function resetButton(array $config = [], array $attributes = []): self
    {
        $new = clone $this;
        $new = $new->type('reset');
        $config = array_merge($new->getDefinitions(), $config);
        $new->button = ResetButton::widget($config)->attributes($attributes);
        return $new;
    }

    /**
     * Renders a select widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config The configuration array for widget factory.
     * Available methods:
     * [
     *     'encode()' => [true],
     *     'groups()' => [['1' => ['2' => 'Moscu', '3' => 'San Petersburg']]],
     *     'items()' => [['1' => 'Moscu', '2' => 'San Petersburg']],
     *     'itemsAttributes()' => [['2' => ['disabled' => true]],
     *     'optionsData()' => [['1' => '<b>Moscu</b>', '2' => 'San Petersburg']],
     *     'prompt()' => [['text' => 'Select City Birth', 'attributes' => ['value' => '0', 'selected' => 'selected']]],
     *     'unselectValue()' => ['0'],
     * ]
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field object itself.
     */
    public function select(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new = $new->type('select');
        $config = array_merge($new->getDefinitions(), $config);
        $new->inputWidget = Select::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a submit button widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field object itself.
     */
    public function submitButton(array $config = [], array $attributes = []): self
    {
        $new = clone $this;
        $new = $new->type('submit');
        $config = array_merge($new->getDefinitions(), $config);
        $new->button = SubmitButton::widget($config)->attributes($attributes);
        return $new;
    }

    /**
     * Renders a text widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config the configuration array for widget factory.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field widget instance.
     */
    public function telephone(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new = $new->type('telephone');
        $config = array_merge($new->getDefinitions(), $config);
        $new->inputWidget = Telephone::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a text widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config the configuration array for widget factory.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field widget instance.
     */
    public function text(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new = $new->type('text');
        $config = array_merge($new->getDefinitions(), $config);
        $new->inputWidget = Text::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a text area widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config the configuration array for widget factory.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field widget instance.
     */
    public function textArea(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new = $new->type('textArea');
        $config = array_merge($new->getDefinitions(), $config);
        $new->inputWidget = TextArea::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders a url widget.
     *
     * @param FormModelInterface $formModel The model object.
     * @param string $attribute The attribute name or expression.
     * @param array $config the configuration array for widget factory.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return static the field widget instance.
     */
    public function url(FormModelInterface $formModel, string $attribute, array $config = []): self
    {
        $new = clone $this;
        $new = $new->type('url');
        $config = array_merge($new->getDefinitions(), $config);
        $new->inputWidget = Url::widget($config)->for($formModel, $attribute);
        return $new;
    }

    /**
     * Renders the whole field.
     *
     * This method will generate the label, input tag and hint tag (if any), and assemble them into HTML according to
     * {@see template}.
     *
     * If (not set), the default methods will be called to generate the label and input tag, and use them as the
     * content.
     *
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     *
     * @return string the rendering result.
     */
    protected function run(): string
    {
        $content = '';

        $div = Div::tag();

        if (!empty($this->inputWidget)) {
            $content .= $this->renderInputWidget();
        }

        if (!empty($this->widget)) {
            $content .= $this->widget->attributes($this->getAttributes())->render();
        }

        if (!empty($this->button)) {
            $content .= $this->button->attributes($this->getAttributes())->render();
        }

        if ($this->getContainerClass() !== '') {
            $div = $div->class($this->getContainerClass());
        }

        if ($this->getContainerAttributes() !== []) {
            $div = $div->attributes($this->getContainerAttributes());
        }

        return $this->getContainer() ? $div->content(PHP_EOL . $content . PHP_EOL)->encode(false)->render() : $content;
    }

    private function buildField(): self
    {
        $new = clone $this;

        // Set ariadescribedby.
        if ($new->getAriaDescribedBy() === true && $new->inputWidget instanceof InputAttributes) {
            $new->inputWidget = $new->inputWidget->ariaDescribedBy($this->inputWidget->getInputId() . '-help');
        }

        // Set encode.
        $new->inputWidget = $new->inputWidget->encode($new->getEncode());

        // Set input class.
        $inputClass = $new->getInputClass();

        if ($inputClass !== '') {
            $new->inputWidget = $new->inputWidget->class($inputClass);
        }

        // Set placeholder.
        $placeholder = $new->getPlaceholder() ?? $new->inputWidget->getAttributePlaceHolder();

        if ($new->inputWidget instanceof PlaceholderInterface && $placeholder !== '') {
            $new->inputWidget = $new->inputWidget->attributes(['placeholder' => $placeholder]);
        }

        // Set valid class and invalid class.
        $invalidClass = $new->getInvalidClass();
        $validClass = $new->getValidClass();

        if ($invalidClass !== '' && $new->inputWidget->hasError()) {
            $new->inputWidget = $new->inputWidget->class($invalidClass);
        } elseif ($validClass !== '' && $new->inputWidget->isValidated()) {
            $new->inputWidget = $new->inputWidget->class($validClass);
        }

        // Set attributes.
        $new->inputWidget = $new->inputWidget->attributes($this->getAttributes());

        return $new;
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    private function renderError(): string
    {
        $errorAttributes = $this->getErrorAttributes();
        $errorClass = $this->getErrorClass();

        if ($errorClass !== '') {
            Html::addCssClass($errorAttributes, $errorClass);
        }

        return Error::widget()
            ->attributes($errorAttributes)
            ->encode($this->getEncode())
            ->for($this->inputWidget->getFormModel(), $this->inputWidget->getAttribute())
            ->message($this->getError() ?? '')
            ->messageCallback($this->getErrorMessageCallback())
            ->tag($this->getErrorTag())
            ->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    private function renderInputWidget(): string
    {
        $new = clone $this;

        $new = $new->buildField();

        if (!array_key_exists('{input}', $new->parts)) {
            $new->parts['{input}'] = $new->inputWidget->render();
        }

        if (!array_key_exists('{error}', $new->parts)) {
            $new->parts['{error}'] = $this->getError() !== null ? $new->renderError() : '';
        }

        if (!array_key_exists('{hint}', $new->parts)) {
            $new->parts['{hint}'] = $new->renderHint();
        }

        if (!array_key_exists('{label}', $new->parts)) {
            $new->parts['{label}'] = $new->renderLabel();
        }

        if ($new->getDefaultTokens() !== []) {
            $new->parts = array_merge($new->parts, $new->getDefaultTokens());
        }

        return preg_replace('/^\h*\v+/m', '', trim(strtr($new->getTemplate(), $new->parts)));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    private function renderHint(): string
    {
        $hintAttributes = $this->getHintAttributes();
        $hintClass = $this->getHintClass();

        if ($hintClass !== '') {
            Html::addCssClass($hintAttributes, $hintClass);
        }

        if ($this->getAriaDescribedBy() === true) {
            $hintAttributes['id'] = $this->inputWidget->getInputId() . '-help';
        }

        return Hint::widget()
            ->attributes($hintAttributes)
            ->encode($this->getEncode())
            ->for($this->inputWidget->getFormModel(), $this->inputWidget->getAttribute())
            ->hint($this->getHint())
            ->tag($this->getHintTag())
            ->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    private function renderLabel(): string
    {
        $labelAttributes = $this->getLabelAttributes();
        $labelClass = $this->getLabelClass();

        if (!array_key_exists('for', $labelAttributes)) {
            /** @var string */
            $labelAttributes['for'] = ArrayHelper::getValue(
                $this->getAttributes(),
                'id',
                $this->inputWidget->getInputId(),
            );
        }

        if ($labelClass !== '') {
            Html::addCssClass($labelAttributes, $labelClass);
        }

        return Label::widget()
            ->attributes($labelAttributes)
            ->encode($this->getEncode())
            ->for($this->inputWidget->getFormModel(), $this->inputWidget->getAttribute())
            ->label($this->getLabel())
            ->render();
    }
}
