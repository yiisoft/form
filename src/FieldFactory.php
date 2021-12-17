<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Yiisoft\Form\Field\InputText;
use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Field\Part\Label;

final class FieldFactory
{
    private ?string $template;

    private ?bool $setInputIdAttribute;

    private array $labelConfig;
    private array $hintConfig;
    private array $errorConfig;

    private array $inputTextConfig;

    public function __construct(FieldFactoryConfig $config)
    {
        $this->template = $config->getTemplate();

        $this->setInputIdAttribute = $config->getSetInputIdAttribute();

        $this->labelConfig = $config->getLabelConfig();
        $this->hintConfig = $config->getHintConfig();
        $this->errorConfig = $config->getErrorConfig();

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
        $config = array_merge(
            $this->makeFieldConfig([
                'template()',
                'setInputIdAttribute()',
                'labelConfig()',
                'hintConfig()',
            ]),
            $this->inputTextConfig
        );

        return InputText::widget($config)->attribute($formModel, $attribute);
    }

    /**
     * @param string[] $keys
     */
    private function makeFieldConfig(array $keys): array
    {
        $config = [];
        foreach ($keys as $key) {
            switch ($key) {
                case 'template()':
                    if ($this->template !== null) {
                        $config[$key] = [$this->template];
                    }
                    break;

                case 'setInputIdAttribute()':
                    if ($this->setInputIdAttribute !== null) {
                        $config[$key] = [$this->setInputIdAttribute];
                    }
                    break;

                case 'labelConfig()':
                    $labelConfig = $this->makeLabelConfig();
                    if ($labelConfig !== []) {
                        $config[$key] = [$labelConfig];
                    }
                    break;

                case 'hintConfig()':
                    if ($this->hintConfig !== []) {
                        $config[$key] = [$this->hintConfig];
                    }
                    break;

                case 'errorConfig()':
                    if ($this->errorConfig !== []) {
                        $config[$key] = [$this->errorConfig];
                    }
                    break;
            }
        }
        return $config;
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
