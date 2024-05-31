<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\Button;
use Yiisoft\Form\Field\ButtonGroup;
use Yiisoft\Form\Field\Checkbox;
use Yiisoft\Form\Field\CheckboxList;
use Yiisoft\Form\Field\Date;
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
use Yiisoft\Form\Field\Time;
use Yiisoft\Form\Field\Url;

/**
 * @psalm-import-type Errors from ErrorSummary
 */
class PureFieldFactory
{
    final public function __construct(
        protected readonly ?string $defaultTheme = null,
    ) {
    }

    final public function button(?string $content = null, array $config = [], ?string $theme = null): Button
    {
        $field = Button::widget(config: $config, theme: $theme ?? $this->defaultTheme);

        if ($content !== null) {
            $field = $field->content($content);
        }

        return $field;
    }

    final public function buttonGroup(array $config = [], ?string $theme = null): ButtonGroup
    {
        return ButtonGroup::widget(config: $config, theme: $theme ?? $this->defaultTheme);
    }

    final public function checkbox(
        ?string $name = null,
        mixed $value = null,
        array $config = [],
        ?string $theme = null,
    ): Checkbox {
        return Checkbox::widget(config: $config, theme: $theme ?? $this->defaultTheme)
            ->inputData(new PureInputData($name, $value));
    }

    final public function checkboxList(
        ?string $name = null,
        mixed $value = null,
        array $config = [],
        ?string $theme = null,
    ): CheckboxList {
        return CheckboxList::widget(config: $config, theme: $theme ?? $this->defaultTheme)
            ->inputData(new PureInputData($name, $value));
    }

    final public function date(
        ?string $name = null,
        mixed $value = null,
        array $config = [],
        ?string $theme = null,
    ): Date {
        return Date::widget(config: $config, theme: $theme ?? $this->defaultTheme)
            ->inputData(new PureInputData($name, $value));
    }

    final public function dateTimeLocal(
        ?string $name = null,
        mixed $value = null,
        array $config = [],
        ?string $theme = null,
    ): DateTimeLocal {
        return DateTimeLocal::widget(config: $config, theme: $theme ?? $this->defaultTheme)
            ->inputData(new PureInputData($name, $value));
    }

    final public function email(
        ?string $name = null,
        mixed $value = null,
        array $config = [],
        ?string $theme = null,
    ): Email {
        return Email::widget(config: $config, theme: $theme ?? $this->defaultTheme)
            ->inputData(new PureInputData($name, $value));
    }

    /**
     * @psalm-param Errors $errors
     */
    final public function errorSummary(
        array $errors = [],
        array $config = [],
        ?string $theme = null,
    ): ErrorSummary {
        return ErrorSummary::widget(config: $config, theme: $theme ?? $this->defaultTheme)->errors($errors);
    }

    final public function fieldset(array $config = [], ?string $theme = null): Fieldset
    {
        return Fieldset::widget(config: $config, theme: $theme ?? $this->defaultTheme);
    }

    final public function file(
        ?string $name = null,
        mixed $value = null,
        array $config = [],
        ?string $theme = null,
    ): File {
        return File::widget(config: $config, theme: $theme ?? $this->defaultTheme)
            ->inputData(new PureInputData($name, $value));
    }

    final public function hidden(
        ?string $name = null,
        mixed $value = null,
        array $config = [],
        ?string $theme = null,
    ): Hidden {
        return Hidden::widget(config: $config, theme: $theme ?? $this->defaultTheme)
            ->inputData(new PureInputData($name, $value));
    }

    final public function image(?string $url = null, array $config = [], ?string $theme = null): Image
    {
        $field = Image::widget(config: $config, theme: $theme ?? $this->defaultTheme);

        if ($url !== null) {
            $field = $field->src($url);
        }

        return $field;
    }

    final public function number(
        ?string $name = null,
        mixed $value = null,
        array $config = [],
        ?string $theme = null,
    ): Number {
        return Number::widget(config: $config, theme: $theme ?? $this->defaultTheme)
            ->inputData(new PureInputData($name, $value));
    }

    final public function password(
        ?string $name = null,
        mixed $value = null,
        array $config = [],
        ?string $theme = null,
    ): Password {
        return Password::widget(config: $config, theme: $theme ?? $this->defaultTheme)
            ->inputData(new PureInputData($name, $value));
    }

    final public function radioList(
        ?string $name = null,
        mixed $value = null,
        array $config = [],
        ?string $theme = null,
    ): RadioList {
        return RadioList::widget(config: $config, theme: $theme ?? $this->defaultTheme)
            ->inputData(new PureInputData($name, $value));
    }

    final public function range(
        ?string $name = null,
        mixed $value = null,
        array $config = [],
        ?string $theme = null,
    ): Range {
        return Range::widget(config: $config, theme: $theme ?? $this->defaultTheme)
            ->inputData(new PureInputData($name, $value));
    }

    final public function resetButton(
        ?string $content = null,
        array $config = [],
        ?string $theme = null,
    ): ResetButton {
        $field = ResetButton::widget(config: $config, theme: $theme ?? $this->defaultTheme);

        if ($content !== null) {
            $field = $field->content($content);
        }

        return $field;
    }

    final public function select(
        ?string $name = null,
        mixed $value = null,
        array $config = [],
        ?string $theme = null,
    ): Select {
        return Select::widget(config: $config, theme: $theme ?? $this->defaultTheme)
            ->inputData(new PureInputData($name, $value));
    }

    final public function submitButton(
        ?string $content = null,
        array $config = [],
        ?string $theme = null,
    ): SubmitButton {
        $field = SubmitButton::widget(config: $config, theme: $theme ?? $this->defaultTheme);

        if ($content !== null) {
            $field = $field->content($content);
        }

        return $field;
    }

    final public function telephone(
        ?string $name = null,
        mixed $value = null,
        array $config = [],
        ?string $theme = null,
    ): Telephone {
        return Telephone::widget(config: $config, theme: $theme ?? $this->defaultTheme)
            ->inputData(new PureInputData($name, $value));
    }

    final public function text(
        ?string $name = null,
        mixed $value = null,
        array $config = [],
        ?string $theme = null,
    ): Text {
        return Text::widget(config: $config, theme: $theme ?? $this->defaultTheme)
            ->inputData(new PureInputData($name, $value));
    }

    final public function textarea(
        ?string $name = null,
        mixed $value = null,
        array $config = [],
        ?string $theme = null,
    ): Textarea {
        return Textarea::widget(config: $config, theme: $theme ?? $this->defaultTheme)
            ->inputData(new PureInputData($name, $value));
    }

    final public function time(
        ?string $name = null,
        mixed $value = null,
        array $config = [],
        ?string $theme = null,
    ): Time {
        return Time::widget(config: $config, theme: $theme ?? $this->defaultTheme)
            ->inputData(new PureInputData($name, $value));
    }

    final public function url(
        ?string $name = null,
        mixed $value = null,
        array $config = [],
        ?string $theme = null,
    ): Url {
        return Url::widget(config: $config, theme: $theme ?? $this->defaultTheme)
            ->inputData(new PureInputData($name, $value));
    }

    final public function label(?string $content = null, array $config = [], ?string $theme = null): Label
    {
        return Label::widget(config: $config, theme: $theme ?? $this->defaultTheme)->content($content);
    }

    final public function hint(?string $content = null, array $config = [], ?string $theme = null): Hint
    {
        return Hint::widget(config: $config, theme: $theme ?? $this->defaultTheme)->content($content);
    }

    final public function error(?string $message = null, array $config = [], ?string $theme = null): Error
    {
        return Error::widget(config: $config, theme: $theme ?? $this->defaultTheme)->message($message);
    }
}
