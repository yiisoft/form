<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use InvalidArgumentException;
use RuntimeException;

use Yiisoft\Form\Field\Base\AbstractInputField;
use Yiisoft\Form\Field\Base\AbstractField;
use Yiisoft\Form\Field\Base\PlaceholderTrait;
use Yiisoft\Form\Field\Checkbox;
use Yiisoft\Form\Field\Date;
use Yiisoft\Form\Field\DateTime;
use Yiisoft\Form\Field\DateTimeLocal;
use Yiisoft\Form\Field\Email;
use Yiisoft\Form\Field\Hidden;
use Yiisoft\Form\Field\Image;
use Yiisoft\Form\Field\Number;
use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Field\Part\Label;
use Yiisoft\Form\Field\Password;
use Yiisoft\Form\Field\Range;
use Yiisoft\Form\Field\ResetButton;
use Yiisoft\Form\Field\Select;
use Yiisoft\Form\Field\SubmitButton;
use Yiisoft\Form\Field\Telephone;
use Yiisoft\Form\Field\Text;
use Yiisoft\Form\Field\Textarea;
use Yiisoft\Form\Field\Url;
use Yiisoft\Widget\WidgetFactory;

use function in_array;

final class FieldFactory
{
    private const SUPPORT_PLACEHOLDER = 1;

    private ?array $baseFieldConfig = null;

    /**
     * @param array[] $fieldConfigs
     */
    public function __construct(
        private ?string $containerTag = null,
        private array $containerTagAttributes = [],
        private ?bool $useContainer = null,
        private ?string $template = null,
        private ?bool $setInputIdAttribute = null,
        private array $inputTagAttributes = [],
        private array $labelConfig = [],
        private array $hintConfig = [],
        private array $errorConfig = [],
        private ?bool $usePlaceholder = null,
        private array $fieldConfigs = [],
    ) {
    }

    public function checkbox(FormModelInterface $formModel, string $attribute, array $config = []): Checkbox
    {
        return $this->input(Checkbox::class, $formModel, $attribute, $config);
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
            $this->makeLabelConfig(),
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
        if (!$widget instanceof AbstractInputField) {
            throw new InvalidArgumentException(
                sprintf(
                    'Input widget must be instance of "%s".',
                    AbstractInputField::class
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
        $traits = class_uses($class);
        if ($traits === false) {
            throw new RuntimeException('Invalid field class.');
        }

        $supports = [];
        if (in_array(PlaceholderTrait::class, $traits, true)) {
            $supports[] = self::SUPPORT_PLACEHOLDER;
        }

        $config = array_merge(
            $this->makeFieldConfig($supports),
            $this->fieldConfigs[$class] ?? [],
            $config,
            ['class' => $class],
        );

        /** @psalm-var T&AbstractField */
        return WidgetFactory::createWidget($config);
    }

    /**
     * @param int[] $supports
     */
    private function makeFieldConfig(array $supports): array
    {
        $config = $this->makeBaseFieldConfig();
        foreach ($supports as $support) {
            switch ($support) {
                case self::SUPPORT_PLACEHOLDER:
                    if ($this->usePlaceholder !== null) {
                        $config['usePlaceholder()'] = [$this->usePlaceholder];
                    }
                    break;
            }
        }
        return $config;
    }

    private function makeBaseFieldConfig(): array
    {
        if ($this->baseFieldConfig === null) {
            $this->baseFieldConfig = [];

            if ($this->containerTag !== null) {
                $this->baseFieldConfig['containerTag()'] = [$this->containerTag];
            }

            if ($this->containerTagAttributes !== []) {
                $this->baseFieldConfig['containerTagAttributes()'] = [$this->containerTagAttributes];
            }

            if ($this->useContainer !== null) {
                $this->baseFieldConfig['useContainer()'] = [$this->useContainer];
            }

            if ($this->template !== null) {
                $this->baseFieldConfig['template()'] = [$this->template];
            }

            if ($this->setInputIdAttribute !== null) {
                $this->baseFieldConfig['setInputIdAttribute()'] = [$this->setInputIdAttribute];
            }

            if ($this->inputTagAttributes !== []) {
                $this->baseFieldConfig['inputTagAttributes()'] = [$this->inputTagAttributes];
            }

            $labelConfig = $this->makeLabelConfig();
            if ($labelConfig !== []) {
                $this->baseFieldConfig['labelConfig()'] = [$labelConfig];
            }

            if ($this->hintConfig !== []) {
                $this->baseFieldConfig['hintConfig()'] = [$this->hintConfig];
            }

            if ($this->errorConfig !== []) {
                $this->baseFieldConfig['errorConfig()'] = [$this->errorConfig];
            }
        }
        return $this->baseFieldConfig;
    }

    private function makeLabelConfig(): array
    {
        $config = [];

        if ($this->setInputIdAttribute === false) {
            $config['useInputIdAttribute()'] = [false];
        }

        return array_merge($config, $this->labelConfig);
    }
}
