<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Yiisoft\Form\Field\InputText;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Html\Tag\Label;

final class FieldFactory
{
    private ?string $template;

    private ?bool $setInputIdAttribute;

    private ?Label $labelTag;
    private ?bool $setLabelForAttribute;

    private array $inputTextConfig;

    public function __construct(FieldFactoryConfig $config)
    {
        $this->template = $config->getTemplate();

        $this->setInputIdAttribute = $config->getSetInputIdAttribute();

        $this->labelTag = $config->getLabelTag();
        $this->setLabelForAttribute = $config->getSetLabelForAttribute();

        $this->inputTextConfig = $config->getInputTextConfig();
    }

    public function label(FormModelInterface $formModel, string $attribute): Label
    {
        $tag = $this->labelTag ?? Label::tag();
        $tag = $tag->content(HtmlForm::getAttributeLabel($formModel, $attribute));

        if (
            ($this->setLabelForAttribute ?? true)
            && $tag->getAttribute('for') === null
        ) {
            $id = $this->getInputId($formModel, $attribute);
            if ($id !== null) {
                $tag = $tag->forId($id);
            }
        }

        return $tag;
    }

    public function inputText(FormModelInterface $formModel, string $attribute): InputText
    {
        $config = array_merge(
            $this->makeWidgetConfig([
                'template()',
                'setInputIdAttribute()',
                'labelTag()',
                'setLabelForAttribute()',
            ]),
            $this->inputTextConfig
        );

        return InputText::widget($config)->attribute($formModel, $attribute);
    }

    private function makeWidgetConfig(array $keys): array
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

                case 'labelTag()':
                    if ($this->labelTag !== null) {
                        $config[$key] = [$this->labelTag];
                    }
                    break;

                case 'setLabelForAttribute()':
                    if ($this->setLabelForAttribute !== null) {
                        $config[$key] = [$this->setLabelForAttribute];
                    }
                    break;
            }
        }
        return $config;
    }

    private function getInputId(FormModelInterface $formModel, string $attribute): ?string
    {
        if (!($this->setInputIdAttribute ?? true)) {
            return null;
        }

        return $this->inputId ?? HtmlForm::getInputId($formModel, $attribute);
    }
}
