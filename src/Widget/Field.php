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
    /** @psalm-var ButtonAttributes[] */
    private array $buttons = [];
    private WidgetAttributes $inputWidget;
    private GlobalAttributes $widget;

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
        $new->parts['{label}'] = '';
        $new->parts['{hint}'] = '';
        $new->parts['{error}'] = '';
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
        $new->parts['{label}'] = '';
        $new->parts['{hint}'] = '';
        $new->parts['{error}'] = '';
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
        $new->buttons[] = ResetButton::widget($config)->attributes($attributes);
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
        $new->buttons[] = SubmitButton::widget($config)->attributes($attributes);
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

        if ($this->getContainerClass() !== '') {
            $div = $div->class($this->getContainerClass());
        }

        if ($this->getContainerAttributes() !== []) {
            $div = $div->attributes($this->getContainerAttributes());
        }

        if (!empty($this->inputWidget)) {
            $content .= $this->renderInputWidget();
        }

        if (!empty($this->widget)) {
            $content .= $this->widget->attributes($this->attributes)->render();
        }

        $renderButtons = $this->renderButtons();

        if ($renderButtons !== '') {
            $content .= $renderButtons;
        }

        return $this->getContainer() ? $div->content(PHP_EOL . $content . PHP_EOL)->encode(false)->render() : $content;
    }

    private function buildField(): self
    {
        $new = clone $this;

        // Set ariadescribedby.
        if ($new->getAriaDescribedBy() === true && $new->inputWidget instanceof InputAttributes) {
            $new->inputWidget = $new->inputWidget->ariaDescribedBy($new->inputWidget->getAttribute() . 'Help');
        }

        // Set encode.
        $new->inputWidget = $new->inputWidget->encode($new->getEncode());

        // Set input class.
        if ($new->inputClass !== '') {
            $new->inputWidget = $new->inputWidget->class($new->inputClass);
        }

        // Set placeholder.
        $new->placeholder ??= $new->inputWidget->getAttributePlaceHolder();

        if ($new->inputWidget instanceof PlaceholderInterface && $new->placeholder !== '') {
            $new->inputWidget = $new->inputWidget->attributes(['placeholder' => $new->placeholder]);
        }

        // Set valid class and invalid class.
        if ($new->invalidClass !== '' && $new->inputWidget->hasError()) {
            $new->inputWidget = $new->inputWidget->class($new->invalidClass);
        } elseif ($new->validClass !== '' && $new->inputWidget->isValidated()) {
            $new->inputWidget = $new->inputWidget->class($new->validClass);
        }

        // Set attributes.
        $new->inputWidget = $new->inputWidget->attributes($this->attributes);

        return $new;
    }

    private function renderButtons(): string
    {
        $buttons = '';

        foreach ($this->buttons as $key => $button) {
            $buttonsAttributes = $this->getButtonsIndividualAttributes((string) $key) ?? $this->attributes;

            // Set input class.
            if ($this->inputClass !== '') {
                $button = $button->class($this->inputClass);
            }

            $buttons .= $button->attributes($buttonsAttributes)->render();
        }

        return $buttons;
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    private function renderError(): string
    {
        $errorAttributes = $this->getErrorAttributes();
        $errorClass = $this->getErrorIndividualClass($this->type) ?? $this->getErrorClass();

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

        return preg_replace('/^\h*\v+/m', '', trim(strtr($new->template, $new->parts)));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    private function renderHint(): string
    {
        $hintAttributes = $this->getHintAttributes();
        $hintClass = $this->getHintIndividualClass($this->type) ?? $this->getHintClass();

        if ($hintClass !== '') {
            Html::addCssClass($hintAttributes, $hintClass);
        }

        if ($this->getAriaDescribedBy() === true) {
            $hintAttributes['id'] = $this->inputWidget->getInputId();
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
        $labelClass = $this->getLabelIndividualClass($this->type) ?? $this->getLabelClass();

        if (!array_key_exists('for', $labelAttributes)) {
            /** @var string */
            $labelAttributes['for'] = ArrayHelper::getValue($this->attributes, 'id', $this->inputWidget->getInputId());
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
