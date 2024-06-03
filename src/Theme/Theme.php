<?php

declare(strict_types=1);

namespace Yiisoft\Form\Theme;

use Yiisoft\Form\Field\Base\EnrichFromValidationRules\EnrichFromValidationRulesInterface;
use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Form\Field\Base\PartsField;
use Yiisoft\Form\Field\Base\Placeholder\PlaceholderInterface;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassInterface;

final class Theme
{
    /**
     * @param array[] $fieldConfigs
     */
    public function __construct(
        private ?string $containerTag = null,
        private array $containerAttributes = [],
        private string|array|null $containerClass = null,
        private ?bool $useContainer = null,
        private ?string $template = null,
        private ?string $templateBegin = null,
        private ?string $templateEnd = null,
        private ?bool $setInputId = null,
        private array $inputAttributes = [],
        private string|array|null $inputClass = null,
        private ?string $inputContainerTag = null,
        private array $inputContainerAttributes = [],
        private string|array|null $inputContainerClass = null,
        string|array|null $labelClass = null,
        private array $labelConfig = [],
        string|array|null $hintClass = null,
        private array $hintConfig = [],
        string|array|null $errorClass = null,
        private array $errorConfig = [],
        private ?bool $usePlaceholder = null,
        private ?string $validClass = null,
        private ?string $invalidClass = null,
        private ?string $inputValidClass = null,
        private ?string $inputInvalidClass = null,
        private ?bool $enrichFromValidationRules = null,
        private array $fieldConfigs = [],
    ) {
        if ($labelClass !== null) {
            $this->labelConfig['class()'] = is_array($labelClass) ? $labelClass : [$labelClass];
        }
        if ($hintClass !== null) {
            $this->hintConfig['class()'] = is_array($hintClass) ? $hintClass : [$hintClass];
        }
        if ($errorClass !== null) {
            $this->errorConfig['class()'] = is_array($errorClass) ? $errorClass : [$errorClass];
        }
    }

    public function getLabelConfig(): array
    {
        return $this->labelConfig;
    }

    public function getHintConfig(): array
    {
        return $this->hintConfig;
    }

    public function getErrorConfig(): array
    {
        return $this->errorConfig;
    }

    /**
     * @psalm-param class-string $class
     */
    public function getFieldConfig(string $class): array
    {
        $config = [];

        if ($this->containerTag !== null) {
            $config['containerTag()'] = [$this->containerTag];
        }
        if ($this->containerAttributes !== []) {
            $config['containerAttributes()'] = [$this->containerAttributes];
        }
        if ($this->containerClass !== null) {
            $config['containerClass()'] = is_array($this->containerClass)
                ? $this->containerClass
                : [$this->containerClass];
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
            if ($this->inputContainerTag !== null) {
                $config['inputContainerTag()'] = [$this->inputContainerTag];
            }
            if ($this->inputContainerAttributes !== []) {
                $config['inputContainerAttributes()'] = [$this->inputContainerAttributes];
            }
            if ($this->inputContainerClass !== null) {
                $config['inputContainerClass()'] = is_array($this->inputContainerClass)
                    ? $this->inputContainerClass
                    : [$this->inputContainerClass];
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
            if ($this->setInputId !== null) {
                $config['setInputId()'] = [$this->setInputId];
            }
            if ($this->inputAttributes !== []) {
                $config['inputAttributes()'] = [$this->inputAttributes];
            }
            if ($this->inputClass !== null) {
                $config['inputClass()'] = is_array($this->inputClass)
                    ? $this->inputClass
                    : [$this->inputClass];
            }
        }

        if (is_a($class, PlaceholderInterface::class, true)) {
            if ($this->usePlaceholder !== null) {
                $config['usePlaceholder()'] = [$this->usePlaceholder];
            }
        }

        if (is_a($class, EnrichFromValidationRulesInterface::class, true)) {
            if ($this->enrichFromValidationRules !== null) {
                $config['enrichFromValidationRules()'] = [$this->enrichFromValidationRules];
            }
        }

        if (is_a($class, ValidationClassInterface::class, true)) {
            if ($this->validClass !== null) {
                $config['validClass()'] = [$this->validClass];
            }
            if ($this->invalidClass !== null) {
                $config['invalidClass()'] = [$this->invalidClass];
            }
            if ($this->inputValidClass !== null) {
                $config['inputValidClass()'] = [$this->inputValidClass];
            }
            if ($this->inputInvalidClass !== null) {
                $config['inputInvalidClass()'] = [$this->inputInvalidClass];
            }
        }

        if (!empty($this->fieldConfigs[$class])) {
            $config = array_merge($config, $this->fieldConfigs[$class]);
        }

        return $config;
    }
}
