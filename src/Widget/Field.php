<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Form\Widget\Attribute\FieldAttributes;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Div;

use function strtr;

/**
 * Renders the field widget along with label and hint tag (if any) according to template.
 *
 * @psalm-suppress MissingConstructor
 */
final class Field extends AbstractWidget
{
    use FieldAttributes;

    public const TYPE_CHECKBOX = Checkbox::class;
    public const TYPE_CHECKBOX_LIST = CheckboxList::class;
    public const TYPE_DATE = Date::class;
    public const TYPE_DATE_TIME = DateTime::class;
    public const TYPE_DATE_TIME_LOCAL = DateTimeLocal::class;
    public const TYPE_EMAIL = Email::class;
    public const TYPE_ERROR = Error::class;
    public const TYPE_FILE = File::class;
    public const TYPE_HIDDEN = Hidden::class;
    public const TYPE_HINT = Hint::class;
    public const TYPE_LABEL = Label::class;
    public const TYPE_NUMBER = Number::class;
    public const TYPE_PASSWORD = Password::class;
    public const TYPE_RADIO = Radio::class;
    public const TYPE_RADIO_LIST = RadioList::class;
    public const TYPE_RANGE = Range::class;
    public const TYPE_SELECT = Select::class;
    public const TYPE_SUBMIT_BUTTON = SubmitButton::class;
    public const TYPE_TELEPHONE = Telephone::class;
    public const TYPE_TEXT = Text::class;
    public const TYPE_TEXT_AREA = TextArea::class;
    public const TYPE_URL = Url::class;
    private const HAS_LENGTH_TYPES = [
        self::TYPE_EMAIL,
        self::TYPE_PASSWORD,
        self::TYPE_TELEPHONE,
        self::TYPE_TEXT,
        self::TYPE_TEXT_AREA,
        self::TYPE_URL,
    ];
    private const MATCH_REGULAR_EXPRESSION_TYPES = [
        self::TYPE_EMAIL,
        self::TYPE_PASSWORD,
        self::TYPE_TELEPHONE,
        self::TYPE_TEXT,
        self::TYPE_TEXT_AREA,
        self::TYPE_URL,
    ];
    private const NO_PLACEHOLDER_TYPES = [
        self::TYPE_CHECKBOX,
        self::TYPE_HIDDEN,
        self::TYPE_RADIO,
        self::TYPE_SELECT,
    ];
    private const NUMBER_TYPES = [
        self::TYPE_NUMBER,
        self::TYPE_RANGE,
    ];

    /**
     * Renders a checkbox.
     *
     * This method will generate the `checked` tag attribute according to the model attribute value.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @return static the field widget instance.
     */
    public function checkbox(array $config = [], array $attributes = []): self
    {
        $new = clone $this;

        /** @var array */
        $enclosedByLabel = $config['enclosedByLabel()'] ?? [true];

        if ($enclosedByLabel === [true]) {
            $new->parts['{label}'] = '';
        }

        return $new->build(self::TYPE_CHECKBOX, $attributes, $config);
    }

    /**
     * Renders a list of checkboxes.
     *
     * A checkbox list allows multiple selection, As a result, the corresponding submitted value is an array.
     * The selection of the checkbox list is taken from the value of the model attribute.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @return static the field widget instance.
     */
    public function checkboxList(array $config = [], array $attributes = []): self
    {
        $new = clone $this;
        return $new->build(self::TYPE_CHECKBOX_LIST, $attributes, $config);
    }

    /**
     * Renders a date widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the date widget.
     *
     * @return static the field widget instance.
     */
    public function date(array $config = [], array $attributes = []): self
    {
        $new = clone $this;
        return $new->build(self::TYPE_DATE, $attributes, $config);
    }

    /**
     * Renders a date time widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the date widget.
     *
     * @return static the field widget instance.
     */
    public function dateTime(array $config = [], array $attributes = []): self
    {
        $new = clone $this;
        return $new->build(self::TYPE_DATE_TIME, $attributes, $config);
    }

    /**
     * Renders a date time local widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the date widget.
     *
     * @return static the field widget instance.
     */
    public function dateTimeLocal(array $config = [], array $attributes = []): self
    {
        $new = clone $this;
        return $new->build(self::TYPE_DATE_TIME_LOCAL, $attributes, $config);
    }

    /**
     * Renders a email widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the date widget.
     *
     * @return static the field widget instance.
     */
    public function email(array $config = [], array $attributes = []): self
    {
        $new = clone $this;
        return $new->build(self::TYPE_EMAIL, $attributes, $config);
    }

    /**
     * Generates a tag that contains the first validation error of {@see attribute}.
     *
     * Note that even if there is no validation error, this method will still return an empty error tag.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @return static the field widget instance.
     */
    public function error(array $config = [], array $attributes = []): self
    {
        $new = clone $this;

        $errorClass = $new->errorsClass[$new->type] ?? $new->errorClass;

        if ($errorClass !== '') {
            Html::addCssClass($attributes, $errorClass);
        }

        return $new->build(self::TYPE_ERROR, $attributes, $config, '{error}');
    }

    /**
     * Renders a file widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the date widget.
     *
     * @return static the field widget instance.
     */
    public function file(array $config = [], array $attributes = []): self
    {
        $new = clone $this;
        return $new->build(self::TYPE_FILE, $attributes, $config);
    }

    /**
     * Renders a hidden widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the date widget.
     *
     * @return static the field widget instance.
     */
    public function hidden(array $config = [], array $attributes = []): self
    {
        $new = clone $this;
        $new->parts['{label}'] = '';
        $new->parts['{hint}'] = '';
        $new->parts['{error}'] = '';
        return $new->build(self::TYPE_HIDDEN, $attributes, $config);
    }

    /**
     * Renders the hint tag.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @return static the field widget instance.
     */
    public function hint(array $config = [], array $attributes = []): self
    {
        $new = clone $this;

        if ($new->ariaDescribedBy === true) {
            $attributes['id'] = $new->getId();
        }

        $hintClass = $new->hintsClass[$new->type] ?? $new->hintClass;

        if ($hintClass !== '') {
            Html::addCssClass($attributes, $hintClass);
        }

        return $new->build(self::TYPE_HINT, $attributes, $config, '{hint}');
    }

    /**
     * Renders a image widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @throws InvalidConfigException
     *
     * @return static the field object itself.
     */
    public function image(array $config = [], array $attributes = []): self
    {
        $new = clone $this;

        $new->parts['{error}'] = '';
        $new->parts['{hint}'] = '';
        $new->parts['{label}'] = '';
        $new->parts['{input}'] = Image::widget($config)->attributes($attributes)->render();

        return $new;
    }

    /**
     * Generates a label tag.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @return static the field widget instance.
     */
    public function label(array $config = [], array $attributes = []): self
    {
        $new = clone $this;

        $labelClass = $new->labelsClass[$new->type] ?? $new->labelClass;

        if ($labelClass !== '') {
            Html::addCssClass($attributes, $labelClass);
        }

        return $new->build(self::TYPE_LABEL, $attributes, $config, '{label}');
    }

    /**
     * Renders a number widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @return static the field object itself.
     */
    public function number(array $config = [], array $attributes = []): self
    {
        $new = clone $this;
        return $new->build(self::TYPE_NUMBER, $attributes, $config);
    }

    /**
     * Renders a password widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @return static the field object itself.
     */
    public function password(array $config = [], array $attributes = []): self
    {
        $new = clone $this;
        return $new->build(self::TYPE_PASSWORD, $attributes, $config);
    }

    /**
     * Renders a radio widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @return static the field object itself.
     */
    public function radio(array $config = [], array $attributes = []): self
    {
        $new = clone $this;

        /** @var array */
        $enclosedByLabel = $config['enclosedByLabel()'] ?? [true];

        if ($enclosedByLabel === [true]) {
            $new->parts['{label}'] = '';
        }

        return $new->build(self::TYPE_RADIO, $attributes, $config);
    }

    /**
     * Renders a radio list widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @return static the field object itself.
     */
    public function radiolist(array $config = [], array $attributes = []): self
    {
        $new = clone $this;
        return $new->build(self::TYPE_RADIO_LIST, $attributes, $config);
    }

    /**
     * Renders a range widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @return static the field object itself.
     */
    public function range(array $config = [], array $attributes = []): self
    {
        $new = clone $this;
        return $new->build(self::TYPE_RANGE, $attributes, $config);
    }

    /**
     * Renders a reset button widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @throws InvalidConfigException
     *
     * @return static the field object itself.
     */
    public function resetButton(array $config = [], array $attributes = []): self
    {
        $new = clone $this;

        $new->parts['{error}'] = '';
        $new->parts['{hint}'] = '';
        $new->parts['{label}'] = '';
        $new->parts['{input}'] = ResetButton::widget($config)->attributes($attributes)->render();

        return $new;
    }

    /**
     * Renders a select widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @return static the field object itself.
     */
    public function select(array $config = [], array $attributes = []): self
    {
        $new = clone $this;
        return $new->build(self::TYPE_SELECT, $attributes, $config);
    }

    /**
     * Renders a submit button widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @throws InvalidConfigException
     *
     * @return static the field object itself.
     */
    public function submitButton(array $config = [], array $attributes = []): self
    {
        $new = clone $this;

        $new->type = self::TYPE_SUBMIT_BUTTON;

        $new->parts['{error}'] = '';
        $new->parts['{hint}'] = '';
        $new->parts['{label}'] = '';
        $new->parts['{input}'] = SubmitButton::widget($config)->attributes($attributes)->render();

        return $new;
    }

    /**
     * Renders a text widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @return static the field widget instance.
     */
    public function telephone(array $config = [], array $attributes = []): self
    {
        $new = clone $this;
        return $new->build(self::TYPE_TELEPHONE, $attributes, $config);
    }

    /**
     * Renders a text widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @return static the field widget instance.
     */
    public function text(array $config = [], array $attributes = []): self
    {
        $new = clone $this;
        return $new->build(self::TYPE_TEXT, $attributes, $config);
    }

    /**
     * Renders a text area widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @return static the field widget instance.
     */
    public function textArea(array $config = [], array $attributes = []): self
    {
        $new = clone $this;
        return $new->build(self::TYPE_TEXT_AREA, $attributes, $config);
    }

    /**
     * Renders a url widget.
     *
     * @param array $config the configuration array for widget factory.
     * @param array $attributes the HTML attributes for the widget.
     *
     * @return static the field widget instance.
     */
    public function url(array $config = [], array $attributes = []): self
    {
        $new = clone $this;
        return $new->build(self::TYPE_URL, $attributes, $config);
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
     * @return string the rendering result.
     */
    protected function run(): string
    {
        $new = clone $this;

        $div = Div::tag();

        if (!isset($new->parts['{input}'])) {
            $new->type = self::TYPE_TEXT;
            $new = $new->text();
        }

        if (!isset($new->parts['{label}'])) {
            $new = $new->label();
        }

        if (!isset($new->parts['{hint}'])) {
            $new = $new->hint();
        }

        if (!isset($new->parts['{error}'])) {
            $new = $new->error();
        }

        $containerClass = $new->containersClass[$new->type] ?? $new->containerClass;

        if ($containerClass !== '') {
            $div = $div->class($containerClass);
        }

        $template = $new->templates[$new->type] ?? $new->template;
        $content = preg_replace('/^\h*\v+/m', '', trim(strtr($template, $new->parts)));

        return $div->content(PHP_EOL . $content . PHP_EOL)->encode(false)->render();
    }

    /**
     * Build input tag field.
     *
     * @param string $type the type of tag.
     * @param array $attributes the HTML attributes for the tag.
     * @param array $config the configuration array for widget factory.
     * @param string $parts the parts of tag.
     *
     * @return static the field widget instance.
     */
    private function build(
        string $type,
        array $attributes = [],
        array $config = [],
        string $parts = '{input}'
    ): self {
        $new = clone $this;

        if ($parts === '{input}') {
            $new->type = $type;
            $attributes = $new->setInputAttributes($type, $attributes);
        }

        /** @var AbstractWidget */
        $type = $type::widget($config);
        $new->parts[$parts] = $type->for($new->getFormModel(), $new->getAttribute())->attributes($attributes)->render();
        return $new;
    }
}
