<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\EnrichmentFromRules\EnrichmentFromRulesInterface;
use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Form\Field\Base\PartsField;
use Yiisoft\Form\Field\Base\Placeholder\PlaceholderInterface;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassInterface;
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
use Yiisoft\Widget\WidgetFactory;

final class FieldFactory
{
    /**
     * @param array[] $fieldConfigs
     */
    public function __construct(
        private ?string $containerTag = null,
        private array $containerTagAttributes = [],
        private ?bool $useContainer = null,
        private ?string $template = null,
        private ?string $templateBegin = null,
        private ?string $templateEnd = null,
        private ?bool $setInputIdAttribute = null,
        private array $inputTagAttributes = [],
        private array $labelConfig = [],
        private array $hintConfig = [],
        private array $errorConfig = [],
        private ?bool $usePlaceholder = null,
        private ?string $validClass = null,
        private ?string $invalidClass = null,
        private ?bool $enrichmentFromRules = null,
        private array $fieldConfigs = [],
    ) {
    }

    public function button(array $config = []): Button
    {
        return $this->field(Button::class, $config);
    }

    public function buttonGroup(array $config = []): ButtonGroup
    {
        return $this->field(ButtonGroup::class, $config);
    }

    public function checkbox(FormModelInterface $formModel, string $attribute, array $config = []): Checkbox
    {
        return $this->input(Checkbox::class, $formModel, $attribute, $config);
    }

    public function checkboxList(FormModelInterface $formModel, string $attribute, array $config = []): CheckboxList
    {
        return $this
            ->field(CheckboxList::class, $config)
            ->attribute($formModel, $attribute);
    }

    public function date(FormModelInterface $formModel, string $attribute, array $config = []): Date
    {
        return $this->input(Date::class, $formModel, $attribute, $config);
    }

    public function dateTime(FormModelInterface $formModel, string $attribute, array $config = []): DateTime
    {
        return $this->input(DateTime::class, $formModel, $attribute, $config);
    }

    public function dateTimeLocal(FormModelInterface $formModel, string $attribute, array $config = []): DateTimeLocal
    {
        return $this->input(DateTimeLocal::class, $formModel, $attribute, $config);
    }

    public function email(FormModelInterface $formModel, string $attribute, array $config = []): Email
    {
        return $this->input(Email::class, $formModel, $attribute, $config);
    }

    public function errorSummary(FormModelInterface $formModel, array $config = []): ErrorSummary
    {
        return $this
            ->field(ErrorSummary::class, $config)
            ->formModel($formModel);
    }

    public function fieldset(array $config = []): Fieldset
    {
        return $this->field(Fieldset::class, $config);
    }

    public function file(FormModelInterface $formModel, string $attribute, array $config = []): File
    {
        return $this->input(File::class, $formModel, $attribute, $config);
    }

    public function hidden(FormModelInterface $formModel, string $attribute, array $config = []): Hidden
    {
        return $this->input(Hidden::class, $formModel, $attribute, $config);
    }

    public function image(array $config = []): Image
    {
        return $this->field(Image::class, $config);
    }

    public function number(FormModelInterface $formModel, string $attribute, array $config = []): Number
    {
        return $this->input(Number::class, $formModel, $attribute, $config);
    }

    public function password(FormModelInterface $formModel, string $attribute, array $config = []): Password
    {
        return $this->input(Password::class, $formModel, $attribute, $config);
    }

    public function radioList(FormModelInterface $formModel, string $attribute, array $config = []): RadioList
    {
        return $this
            ->field(RadioList::class, $config)
            ->attribute($formModel, $attribute);
    }

    public function range(FormModelInterface $formModel, string $attribute, array $config = []): Range
    {
        return $this->input(Range::class, $formModel, $attribute, $config);
    }

    public function resetButton(array $config = []): ResetButton
    {
        return $this->field(ResetButton::class, $config);
    }

    public function select(FormModelInterface $formModel, string $attribute, array $config = []): Select
    {
        return $this->input(Select::class, $formModel, $attribute, $config);
    }

    public function submitButton(array $config = []): SubmitButton
    {
        return $this->field(SubmitButton::class, $config);
    }

    public function telephone(FormModelInterface $formModel, string $attribute, array $config = []): Telephone
    {
        return $this->input(Telephone::class, $formModel, $attribute, $config);
    }

    public function text(FormModelInterface $formModel, string $attribute, array $config = []): Text
    {
        return $this->input(Text::class, $formModel, $attribute, $config);
    }

    public function textarea(FormModelInterface $formModel, string $attribute, array $config = []): Textarea
    {
        return $this->input(Textarea::class, $formModel, $attribute, $config);
    }

    public function url(FormModelInterface $formModel, string $attribute, array $config = []): Url
    {
        return $this->input(Url::class, $formModel, $attribute, $config);
    }

    public function label(FormModelInterface $formModel, string $attribute, array $config = []): Label
    {
        $widgetConfig = array_merge(
            $this->labelConfig,
            $config,
        );
        return Label::widget($widgetConfig)->attribute($formModel, $attribute);
    }

    public function hint(FormModelInterface $formModel, string $attribute, array $config = []): Hint
    {
        $widgetConfig = array_merge(
            $this->hintConfig,
            $config,
        );
        return Hint::widget($widgetConfig)->attribute($formModel, $attribute);
    }

    public function error(FormModelInterface $formModel, string $attribute, array $config = []): Error
    {
        $widgetConfig = array_merge(
            $this->errorConfig,
            $config,
        );
        return Error::widget($widgetConfig)->attribute($formModel, $attribute);
    }

    /**
     * @psalm-template T
     * @psalm-param class-string<T> $class
     * @psalm-return T
     */
    public function input(string $class, FormModelInterface $formModel, string $attribute, array $config = []): object
    {
        $widget = $this->field($class, $config);
        if (!$widget instanceof InputField) {
            throw new InvalidArgumentException(
                sprintf(
                    'Input widget must be instance of "%s".',
                    InputField::class
                )
            );
        }

        return $widget->attribute($formModel, $attribute);
    }

    /**
     * @psalm-template T
     * @psalm-param class-string<T> $class
     * @psalm-return T
     */
    public function field(string $class, array $config = []): object
    {
        $config = array_merge(
            $this->makeFieldConfig($class),
            $this->fieldConfigs[$class] ?? [],
            $config,
            ['class' => $class],
        );

        /** @psalm-var T */
        return WidgetFactory::createWidget($config);
    }

    /**
     * @psalm-param class-string $class
     */
    private function makeFieldConfig(string $class): array
    {
        $config = [];

        if ($this->containerTag !== null) {
            $config['containerTag()'] = [$this->containerTag];
        }
        if ($this->containerTagAttributes !== []) {
            $config['containerTagAttributes()'] = [$this->containerTagAttributes];
        }
        if ($this->useContainer !== null) {
            $config['useContainer()'] = [$this->useContainer];
        }

        if (is_a($class, PartsField::class, true)) {
            if ($this->template !== null) {
                $config['template()'] = [$this->template];
            }
            if ($this->templateBegin !== null) {
                $config['templateBegin()'] = [$this->templateBegin];
            }
            if ($this->templateEnd !== null) {
                $config['templateEnd()'] = [$this->templateEnd];
            }
            if ($this->labelConfig !== []) {
                $config['labelConfig()'] = [$this->labelConfig];
            }
            if ($this->hintConfig !== []) {
                $config['hintConfig()'] = [$this->hintConfig];
            }
            if ($this->errorConfig !== []) {
                $config['errorConfig()'] = [$this->errorConfig];
            }
        }

        if (is_a($class, InputField::class, true)) {
            if ($this->setInputIdAttribute !== null) {
                $config['setInputIdAttribute()'] = [$this->setInputIdAttribute];
                if ($this->setInputIdAttribute === false) {
                    $config['labelConfig()'] = [
                        $this->labelConfig + ['useInputIdAttribute()' => [false]],
                    ];
                }
            }
            if ($this->inputTagAttributes !== []) {
                $config['inputTagAttributes()'] = [$this->inputTagAttributes];
            }
        }

        if (is_a($class, PlaceholderInterface::class, true)) {
            if ($this->usePlaceholder !== null) {
                $config['usePlaceholder()'] = [$this->usePlaceholder];
            }
        }

        if (is_a($class, EnrichmentFromRulesInterface::class, true)) {
            if ($this->enrichmentFromRules !== null) {
                $config['enrichmentFromRules()'] = [$this->enrichmentFromRules];
            }
        }

        if (is_a($class, ValidationClassInterface::class, true)) {
            if ($this->validClass !== null) {
                $config['validClass()'] = [$this->validClass];
            }
            if ($this->invalidClass !== null) {
                $config['invalidClass()'] = [$this->invalidClass];
            }
        }

        return $config;
    }
}
