<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Yiisoft\Form\Field\Base\InputData\FormModelInputData;
use Yiisoft\Form\Field\Button;
use Yiisoft\Form\Field\ButtonGroup;
use Yiisoft\Form\Field\Checkbox;
use Yiisoft\Form\Field\CheckboxList;
use Yiisoft\Form\Field\Date;
use Yiisoft\Form\Field\DateTime;
use Yiisoft\Form\Field\DateTimeLocal;
use Yiisoft\Form\Field\Email;
use Yiisoft\Form\Field\ErrorSummary;
use Yiisoft\Form\Field\Fieldset;
use Yiisoft\Form\Field\File;
use Yiisoft\Form\Field\Hidden;
use Yiisoft\Form\Field\Image;
use Yiisoft\Form\Field\Number;
use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Field\Part\Label;
use Yiisoft\Form\Field\Password;
use Yiisoft\Form\Field\RadioList;
use Yiisoft\Form\Field\Range;
use Yiisoft\Form\Field\ResetButton;
use Yiisoft\Form\Field\Select;
use Yiisoft\Form\Field\SubmitButton;
use Yiisoft\Form\Field\Telephone;
use Yiisoft\Form\Field\Text;
use Yiisoft\Form\Field\Textarea;
use Yiisoft\Form\Field\Url;

class Field
{
    final public static function button(?string $content = null, array $config = []): Button
    {
        $field = Button::widget($config);

        if ($content !== null) {
            $field = $field->content($content);
        }

        return $field;
    }

    final public static function buttonGroup(array $config = []): ButtonGroup
    {
        return ButtonGroup::widget(config: $config);
    }

    final public static function checkbox(
        FormModelInterface $formModel,
        string $attribute,
        array $config = []
    ): Checkbox {
        return Checkbox::widget(config: $config)->inputData(new FormModelInputData($formModel, $attribute));
    }

    final public static function checkboxList(
        FormModelInterface $formModel,
        string $attribute,
        array $config = []
    ): CheckboxList {
        return CheckboxList::widget(config: $config)->inputData(new FormModelInputData($formModel, $attribute));
    }

    final public static function date(FormModelInterface $formModel, string $attribute, array $config = []): Date
    {
        return Date::widget(config: $config)->inputData(new FormModelInputData($formModel, $attribute));
    }

    final public static function dateTime(
        FormModelInterface $formModel,
        string $attribute,
        array $config = []
    ): DateTime {
        return DateTime::widget(config: $config)->inputData(new FormModelInputData($formModel, $attribute));
    }

    final public static function dateTimeLocal(
        FormModelInterface $formModel,
        string $attribute,
        array $config = []
    ): DateTimeLocal {
        return DateTimeLocal::widget(config: $config)->inputData(new FormModelInputData($formModel, $attribute));
    }

    final public static function email(FormModelInterface $formModel, string $attribute, array $config = []): Email
    {
        return Email::widget(config: $config)->inputData(new FormModelInputData($formModel, $attribute));
    }

    final public static function errorSummary(FormModelInterface $formModel, array $config = []): ErrorSummary
    {
        return ErrorSummary::widget(config: $config)->validationResult($formModel->getValidationResult());
    }

    final public static function fieldset(array $config = []): Fieldset
    {
        return Fieldset::widget(config: $config);
    }

    final public static function file(FormModelInterface $formModel, string $attribute, array $config = []): File
    {
        return File::widget(config: $config)->inputData(new FormModelInputData($formModel, $attribute));
    }

    final public static function hidden(FormModelInterface $formModel, string $attribute, array $config = []): Hidden
    {
        return Hidden::widget(config: $config)->inputData(new FormModelInputData($formModel, $attribute));
    }

    final public static function image(array $config = []): Image
    {
        return Image::widget(config: $config);
    }

    final public static function number(FormModelInterface $formModel, string $attribute, array $config = []): Number
    {
        return Number::widget(config: $config)->inputData(new FormModelInputData($formModel, $attribute));
    }

    final public static function password(
        FormModelInterface $formModel,
        string $attribute,
        array $config = []
    ): Password {
        return Password::widget(config: $config)->inputData(new FormModelInputData($formModel, $attribute));
    }

    final public static function radioList(
        FormModelInterface $formModel,
        string $attribute,
        array $config = []
    ): RadioList {
        return RadioList::widget(config: $config)->inputData(new FormModelInputData($formModel, $attribute));
    }

    final public static function range(FormModelInterface $formModel, string $attribute, array $config = []): Range
    {
        return Range::widget(config: $config)->inputData(new FormModelInputData($formModel, $attribute));
    }

    final public static function resetButton(?string $content = null, array $config = []): ResetButton
    {
        $field = ResetButton::widget(config: $config);

        if ($content !== null) {
            $field = $field->content($content);
        }

        return $field;
    }

    final public static function select(FormModelInterface $formModel, string $attribute, array $config = []): Select
    {
        return Select::widget(config: $config)->inputData(new FormModelInputData($formModel, $attribute));
    }

    final public static function submitButton(?string $content = null, array $config = []): SubmitButton
    {
        $field = SubmitButton::widget(config: $config);

        if ($content !== null) {
            $field = $field->content($content);
        }

        return $field;
    }

    final public static function telephone(
        FormModelInterface $formModel,
        string $attribute,
        array $config = []
    ): Telephone {
        return Telephone::widget(config: $config)->inputData(new FormModelInputData($formModel, $attribute));
    }

    final public static function text(FormModelInterface $formModel, string $attribute, array $config = []): Text
    {
        return Text::widget(config: $config)->inputData(new FormModelInputData($formModel, $attribute));
    }

    final public static function textarea(
        FormModelInterface $formModel,
        string $attribute,
        array $config = []
    ): Textarea {
        return Textarea::widget(config: $config)->inputData(new FormModelInputData($formModel, $attribute));
    }

    final public static function url(FormModelInterface $formModel, string $attribute, array $config = []): Url
    {
        return Url::widget(config: $config)->inputData(new FormModelInputData($formModel, $attribute));
    }

    final public static function label(FormModelInterface $formModel, string $attribute, array $config = []): Label
    {
        return Label::widget(config: $config)->inputData(new FormModelInputData($formModel, $attribute));
    }

    final public static function hint(FormModelInterface $formModel, string $attribute, array $config = []): Hint
    {
        return Hint::widget(config: $config)->inputData(new FormModelInputData($formModel, $attribute));
    }

    final public static function error(FormModelInterface $formModel, string $attribute, array $config = []): Error
    {
        return Error::widget(config: $config)->inputData(new FormModelInputData($formModel, $attribute));
    }
}
