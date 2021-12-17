<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Field\Part\Label;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Html\Tag\Base\ContentTagInterface;
use Yiisoft\Html\Tag\Base\Tag;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Widget\Widget;

abstract class AbstractField extends Widget
{
    use FormAttributeTrait;

    private ?ContentTagInterface $containerTag = null;
    private bool $withoutContainer = false;

    private string $template = "{label}\n{input}\n{hint}\n{error}";

    private ?string $inputId = null;
    private bool $setInputIdAttribute = true;

    private array $labelConfig = [];
    private array $hintConfig = [];
    private array $errorConfig = [];

    final public function containerTag(?ContentTagInterface $tag): self
    {
        $new = clone $this;
        $new->containerTag = $tag;
        return $new;
    }

    final public function withoutContainer(): self
    {
        $new = clone $this;
        $new->withoutContainer = true;
        return $new;
    }

    /**
     * Set layout template for render a field.
     *
     * @param string $template
     *
     * @return static
     */
    final public function template(string $template): self
    {
        $new = clone $this;
        $new->template = $template;
        return $new;
    }

    /**
     * @return static
     */
    final public function inputId(?string $inputId): self
    {
        $new = clone $this;
        $new->inputId = $inputId;
        return $new;
    }

    /**
     * @return static
     */
    final public function setInputIdAttribute(bool $value): self
    {
        $new = clone $this;
        $new->setInputIdAttribute = $value;
        return $new;
    }

    /**
     * @return static
     */
    final public function labelConfig(array $config): self
    {
        $new = clone $this;
        $new->labelConfig = $config;
        return $new;
    }

    /**
     * @return static
     */
    final public function label(?string $content): self
    {
        $new = clone $this;
        $new->labelConfig['content()'] = [$content];
        return $new;
    }

    /**
     * @return static
     */
    final public function hintConfig(array $config): self
    {
        $new = clone $this;
        $new->hintConfig = $config;
        return $new;
    }

    final public function hint(?string $content): self
    {
        $new = clone $this;
        $new->hintConfig['content()'] = [$content];
        return $new;
    }

    /**
     * @return static
     */
    final public function errorConfig(array $config): self
    {
        $new = clone $this;
        $new->errorConfig = $config;
        return $new;
    }

    final protected function getInputName(): string
    {
        return HtmlForm::getInputName($this->getFormModel(), $this->attribute);
    }

    final protected function getInputId(): ?string
    {
        if (!$this->setInputIdAttribute) {
            return null;
        }

        return $this->inputId ?? HtmlForm::getInputId($this->getFormModel(), $this->attribute);
    }

    final protected function prepareIdInInputTag(Tag $tag): Tag
    {
        if (
            $this->setInputIdAttribute
            && $tag->getAttribute('id') === null
        ) {
            $id = $this->getInputId();
            if ($id !== null) {
                $tag = $tag->id($id);
            }
        }

        return $tag;
    }

    final protected function run(): string
    {
        if ($this->withoutContainer) {
            return $this->generateContent();
        }

        $containerTag = $this->containerTag ?? Div::tag();

        return $containerTag->open()
            . PHP_EOL
            . $this->generateContent()
            . PHP_EOL
            . $containerTag->close();
    }

    abstract protected function generateInput(): string;

    private function generateContent(): string
    {
        $parts = [
            '{label}' => $this->generateLabel(),
            '{input}' => $this->generateInput(),
            '{hint}' => $this->generateHint(),
            '{error}' => $this->generateError(),
        ];

        return preg_replace('/^\h*\v+/m', '', trim(strtr($this->template, $parts)));
    }

    private function generateLabel(): string
    {
        $config = $this->labelConfig;

        if (
            $this->setInputIdAttribute === false
            && ($config['useInputIdAttribute()'] ?? [null]) === [null]
        ) {
            $config['useInputIdAttribute()'] = [false];
        }

        return Label::widget($config)
            ->attribute($this->getFormModel(), $this->attribute)
            ->render();
    }

    private function generateHint(): string
    {
        return Hint::widget($this->hintConfig)
            ->attribute($this->getFormModel(), $this->attribute)
            ->render();
    }

    private function generateError(): string
    {
        return Error::widget($this->errorConfig)
            ->attribute($this->getFormModel(), $this->attribute)
            ->render();
    }
}
