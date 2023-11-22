<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Yiisoft\Form\Field\Base\InputData\PureInputData;
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

class PureField
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

    final public static function checkbox(?string $name = null, mixed $value = null, array $config = []): Checkbox
    {
        return Checkbox::widget(config: $config)->inputData(new PureInputData($name, $value));
    }

    final public static function checkboxList(
        ?string $name = null,
        mixed $value = null,
        array $config = []
    ): CheckboxList {
        return CheckboxList::widget(config: $config)->inputData(new PureInputData($name, $value));
    }

    final public static function date(?string $name = null, mixed $value = null, array $config = []): Date
    {
        return Date::widget(config: $config)->inputData(new PureInputData($name, $value));
    }

    final public static function dateTime(?string $name = null, mixed $value = null, array $config = []): DateTime
    {
        return DateTime::widget(config: $config)->inputData(new PureInputData($name, $value));
    }

    final public static function dateTimeLocal(
        ?string $name = null,
        mixed $value = null,
        array $config = []
    ): DateTimeLocal {
        return DateTimeLocal::widget(config: $config)->inputData(new PureInputData($name, $value));
    }

    final public static function email(?string $name = null, mixed $value = null, array $config = []): Email
    {
        return Email::widget(config: $config)->inputData(new PureInputData($name, $value));
    }

    final public static function errorSummary(array $config = []): ErrorSummary
    {
        return ErrorSummary::widget(config: $config);
    }

    final public static function fieldset(array $config = []): Fieldset
    {
        return Fieldset::widget(config: $config);
    }

    final public static function file(?string $name = null, mixed $value = null, array $config = []): File
    {
        return File::widget(config: $config)->inputData(new PureInputData($name, $value));
    }

    final public static function hidden(?string $name = null, mixed $value = null, array $config = []): Hidden
    {
        return Hidden::widget(config: $config)->inputData(new PureInputData($name, $value));
    }

    final public static function image(array $config = []): Image
    {
        return Image::widget(config: $config);
    }

    final public static function number(?string $name = null, mixed $value = null, array $config = []): Number
    {
        return Number::widget(config: $config)->inputData(new PureInputData($name, $value));
    }

    final public static function password(
        ?string $name = null,
        mixed $value = null,
        array $config = []
    ): Password {
        return Password::widget(config: $config)->inputData(new PureInputData($name, $value));
    }

    final public static function radioList(
        ?string $name = null,
        mixed $value = null,
        array $config = []
    ): RadioList {
        return RadioList::widget(config: $config)->inputData(new PureInputData($name, $value));
    }

    final public static function range(?string $name = null, mixed $value = null, array $config = []): Range
    {
        return Range::widget(config: $config)->inputData(new PureInputData($name, $value));
    }

    final public static function resetButton(?string $content = null, array $config = []): ResetButton
    {
        $field = ResetButton::widget(config: $config);

        if ($content !== null) {
            $field = $field->content($content);
        }

        return $field;
    }

    final public static function select(?string $name = null, mixed $value = null, array $config = []): Select
    {
        return Select::widget(config: $config)->inputData(new PureInputData($name, $value));
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
        ?string $name = null,
        mixed $value = null,
        array $config = []
    ): Telephone {
        return Telephone::widget(config: $config)->inputData(new PureInputData($name, $value));
    }

    final public static function text(?string $name = null, mixed $value = null, array $config = []): Text
    {
        return Text::widget(config: $config)->inputData(new PureInputData($name, $value));
    }

    final public static function textarea(?string $name = null, mixed $value = null, array $config = []): Textarea
    {
        return Textarea::widget(config: $config)->inputData(new PureInputData($name, $value));
    }

    final public static function url(?string $name = null, mixed $value = null, array $config = []): Url
    {
        return Url::widget(config: $config)->inputData(new PureInputData($name, $value));
    }

    final public static function label(?string $name = null, mixed $value = null, array $config = []): Label
    {
        return Label::widget(config: $config)->inputData(new PureInputData($name, $value));
    }

    final public static function hint(?string $name = null, mixed $value = null, array $config = []): Hint
    {
        return Hint::widget(config: $config)->inputData(new PureInputData($name, $value));
    }

    final public static function error(?string $name = null, mixed $value = null, array $config = []): Error
    {
        return Error::widget(config: $config)->inputData(new PureInputData($name, $value));
    }
}
