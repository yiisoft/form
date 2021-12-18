<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Yiisoft\Form\Field\InputText;
use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Field\Part\Label;

use function in_array;

final class FieldFactory
{
    private const PLACEHOLDER = 1;

    private const TAG_ATTRIBUTES_PROPERTIES = [
        'containerTagAttributes()',
        'formElementTagAttributes()',
    ];

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

    private array $inputTextConfig;

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

        $this->inputTextConfig = $config->getInputTextConfig();
    }

    public function label(FormModelInterface $formModel, string $attribute): Label
    {
        return Label::widget($this->makeLabelConfig())->attribute($formModel, $attribute);
    }

    public function hint(FormModelInterface $formModel, string $attribute): Hint
    {
        return Hint::widget($this->hintConfig)->attribute($formModel, $attribute);
    }

    public function error(FormModelInterface $formModel, string $attribute): Error
    {
        return Error::widget($this->errorConfig)->attribute($formModel, $attribute);
    }

    public function inputText(FormModelInterface $formModel, string $attribute): InputText
    {
        $config = $this->mergeFieldConfigs(
            $this->makeFieldConfig(self::PLACEHOLDER),
            $this->inputTextConfig
        );

        return InputText::widget($config)->attribute($formModel, $attribute);
    }

    private function mergeFieldConfigs(array $a, array $b): array
    {
        $c = [];

        foreach ($a as $key => $value) {
            if (
                in_array($key, self::TAG_ATTRIBUTES_PROPERTIES, true)
                && isset($b[$key])
            ) {
                $c[$key] = [array_merge($value[0], $b[$key][0])];
            }
        }

        return array_merge($a, $b, $c);
    }

    private function makeFieldConfig(int ...$supports): array
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
