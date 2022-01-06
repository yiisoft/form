<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use RuntimeException;
use Yiisoft\Form\Field\Base\AbstractField;
use Yiisoft\Form\Field\Base\PlaceholderTrait;
use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Field\Part\Label;
use Yiisoft\Widget\WidgetFactory;

use function in_array;

final class FieldFactory
{
    private const PLACEHOLDER = 1;

    //
    // Common
    //

    private ?string $containerTag;
    private array $containerTagAttributes;
    private ?bool $useContainer;

    private ?string $template;

    private ?bool $setInputIdAttribute;

    private array $formElementTagAttributes;

    private array $labelConfig;
    private array $hintConfig;
    private array $errorConfig;

    //
    // Placeholder
    //

    private ?bool $usePlaceholder;

    //
    // Field configurations
    //

    /**
     * @var array[]
     */
    private array $fieldConfigs;

    //
    // Internal properties
    //

    private ?array $baseFieldConfig = null;

    public function __construct(FieldFactoryConfig $config)
    {
        $this->containerTag = $config->getContainerTag();
        $this->containerTagAttributes = $config->getContainerTagAttributes();
        $this->useContainer = $config->getUseContainer();

        $this->template = $config->getTemplate();

        $this->setInputIdAttribute = $config->getSetInputIdAttribute();

        $this->formElementTagAttributes = $config->getFormElementTagAttributes();

        $this->labelConfig = $config->getLabelConfig();
        $this->hintConfig = $config->getHintConfig();
        $this->errorConfig = $config->getErrorConfig();

        $this->usePlaceholder = $config->getUsePlaceholder();

        $this->fieldConfigs = $config->getFieldConfigs();
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
    public function widget(
        string $class,
        FormModelInterface $formModel,
        string $attribute,
        array $config = []
    ): object {
        $traits = class_uses($class);
        if ($traits === false) {
            throw new RuntimeException('Invalid field class.');
        }

        $supports = [];
        if (in_array(PlaceholderTrait::class, $traits, true)) {
            $supports[] = self::PLACEHOLDER;
        }

        $config = array_merge(
            $this->makeFieldConfig($supports),
            $this->fieldConfigs[$class] ?? [],
            $config,
            ['class' => $class],
        );

        /** @psalm-var T&AbstractField $widget */
        $widget = WidgetFactory::createWidget($config);

        return $widget->attribute($formModel, $attribute);
    }

    /**
     * @param int[] $supports
     */
    private function makeFieldConfig(array $supports): array
    {
        $config = $this->makeBaseFieldConfig();
        foreach ($supports as $support) {
            switch ($support) {
                case self::PLACEHOLDER:
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

            if ($this->formElementTagAttributes !== []) {
                $this->baseFieldConfig['formElementTagAttributes()'] = [$this->formElementTagAttributes];
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
