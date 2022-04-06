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

use function in_array;

abstract class AbstractField extends Widget
{
    use FormAttributeTrait;

    /**
     * @psalm-var non-empty-string
     */
    protected string $containerTag = 'div';
    protected array $containerTagAttributes = [];
    protected bool $useContainer = true;

    protected string $template = "{label}\n{input}\n{hint}\n{error}";
    protected ?bool $hideLabel = null;

    protected ?string $inputId = null;
    protected ?string $inputIdFromTag = null;
    protected bool $setInputIdAttribute = true;

    protected array $inputTagAttributes = [];

    protected array $labelConfig = [];
    protected array $hintConfig = [];
    protected array $errorConfig = [];

    /**
     * Identifies the element (or elements) that describes the object.
     *
     * @link https://w3c.github.io/aria/#aria-describedby
     */
    final public function ariaDescribedBy(string $value): static
    {
        $new = clone $this;
        $new->inputTagAttributes['aria-describedby'] = $value;
        return $new;
    }

    /**
     * Defines a string value that labels the current element.
     *
     * @link https://w3c.github.io/aria/#aria-label
     */
    final public function ariaLabel(string $value): static
    {
        $new = clone $this;
        $new->inputTagAttributes['aria-label'] = $value;
        return $new;
    }

    /**
     * Specifies the form element the tag input element belongs to. The value of this attribute must be the ID
     * attribute of a form element in the same document.
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fae-form
     */
    final public function form(string $value): static
    {
        $new = clone $this;
        $new->inputTagAttributes['form'] = $value;
        return $new;
    }

    final public function containerTag(string $tag): static
    {
        if ($tag === '') {
            throw new InvalidArgumentException('Tag name cannot be empty.');
        }

        $new = clone $this;
        $new->containerTag = $tag;
        return $new;
    }

    final public function containerTagAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->containerTagAttributes = $attributes;
        return $new;
    }

    final public function useContainer(bool $use): static
    {
        $new = clone $this;
        $new->useContainer = $use;
        return $new;
    }

    /**
     * Set layout template for render a field.
     */
    final public function template(string $template): static
    {
        $new = clone $this;
        $new->template = $template;
        return $new;
    }

    final public function hideLabel(?bool $hide = true): static
    {
        $new = clone $this;
        $new->hideLabel = $hide;
        return $new;
    }

    final public function inputId(?string $inputId): static
    {
        $new = clone $this;
        $new->inputId = $inputId;
        return $new;
    }

    final public function setInputIdAttribute(bool $value): static
    {
        $new = clone $this;
        $new->setInputIdAttribute = $value;
        return $new;
    }

    final public function inputTagAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->inputTagAttributes = $attributes;
        return $new;
    }

    final public function labelConfig(array $config): static
    {
        $new = clone $this;
        $new->labelConfig = $config;
        return $new;
    }

    final public function label(?string $content): static
    {
        $new = clone $this;
        $new->labelConfig['content()'] = [$content];
        return $new;
    }

    final public function hintConfig(array $config): static
    {
        $new = clone $this;
        $new->hintConfig = $config;
        return $new;
    }

    final public function hint(?string $content): static
    {
        $new = clone $this;
        $new->hintConfig['content()'] = [$content];
        return $new;
    }

    final public function errorConfig(array $config): static
    {
        $new = clone $this;
        $new->errorConfig = $config;
        return $new;
    }

    final protected function getInputName(): string
    {
        return HtmlForm::getInputName($this->getFormModel(), $this->attribute);
    }

    final protected function getInputTagAttributes(): array
    {
        $attributes = $this->inputTagAttributes;

        $this->prepareIdInInputTagAttributes($attributes);

        if ($this->isUsePlaceholder()) {
            /** @psalm-suppress UndefinedMethod */
            $this->preparePlaceholderInInputTagAttributes($attributes);
        }

        return $attributes;
    }

    final protected function prepareIdInInputTagAttributes(array &$attributes): void
    {
        /** @var mixed $idFromTag */
        $idFromTag = $attributes['id'] ?? null;
        if ($idFromTag !== null) {
            $this->inputIdFromTag = (string)$idFromTag;
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

    protected function shouldHideLabel(): bool
    {
        return false;
    }

    private function generateContent(): string
    {
        $parts = [
            '{input}' => $this->generateInput(),
            '{label}' => ($this->hideLabel ?? $this->shouldHideLabel()) ? '' : $this->generateLabel(),
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

    private function isUsePlaceholder(): bool
    {
        $traits = class_uses($this);
        return in_array(PlaceholderTrait::class, $traits, true);
    }
}
