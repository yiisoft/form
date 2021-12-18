<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use InvalidArgumentException;
use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Field\Part\Label;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Widget\Widget;

abstract class AbstractField extends Widget
{
    use FormAttributeTrait;

    /**
     * @psalm-var non-empty-string
     */
    private string $containerTag = 'div';
    private array $containerTagAttributes = [];
    private bool $useContainer = true;

    private string $template = "{label}\n{input}\n{hint}\n{error}";

    private ?string $inputId = null;
    private ?string $inputIdFromTag = null;
    private bool $setInputIdAttribute = true;

    private array $formElementTagAttributes = [];

    private array $labelConfig = [];
    private array $hintConfig = [];
    private array $errorConfig = [];

    /**
     * @return static
     */
    final public function containerTag(string $tag): self
    {
        if ($tag === '') {
            throw new InvalidArgumentException('Tag name cannot be empty.');
        }

        $new = clone $this;
        $new->containerTag = $tag;
        return $new;
    }

    /**
     * @return static
     */
    final public function containerTagAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->containerTagAttributes = $attributes;
        return $new;
    }

    final public function useContainer(bool $use): self
    {
        $new = clone $this;
        $new->useContainer = $use;
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

    final public function formElementTagAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->formElementTagAttributes = $attributes;
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

    final protected function getFormElementTagAttributes(): array
    {
        return $this->formElementTagAttributes;
    }

    final protected function prepareIdInFormElementTagAttributes(array &$attributes): void
    {
        /** @var mixed $idFromTag */
        $idFromTag = $attributes['id'] ?? null;
        if ($idFromTag !== null) {
            $this->inputIdFromTag = (string) $idFromTag;
        }

        if ($this->setInputIdAttribute) {
            if ($this->inputId !== null) {
                $attributes['id'] = $this->inputId;
            } elseif ($idFromTag === null) {
                $attributes['id'] = $this->getInputId();
            }
        }
    }

    final protected function run(): string
    {
        if (!$this->useContainer) {
            return $this->generateContent();
        }

        $containerTag = CustomTag::name($this->containerTag);
        if ($this->containerTagAttributes !== []) {
            $containerTag = $containerTag->attributes($this->containerTagAttributes);
        }

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
            '{input}' => $this->generateInput(),
            '{label}' => $this->generateLabel(),
            '{hint}' => $this->generateHint(),
            '{error}' => $this->generateError(),
        ];

        return preg_replace('/^\h*\v+/m', '', trim(strtr($this->template, $parts)));
    }

    private function generateLabel(): string
    {
        $label = Label::widget($this->labelConfig)
            ->attribute($this->getFormModel(), $this->attribute);

        if ($this->setInputIdAttribute === false) {
            $label = $label->useInputIdAttribute(false);
        }

        if ($this->inputId !== null) {
            $label = $label->forId($this->inputId);
        } elseif ($this->inputIdFromTag !== null) {
            $label = $label->forId($this->inputIdFromTag);
        }

        return $label->render();
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
