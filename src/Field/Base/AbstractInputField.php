<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Field\Part\Label;
use Yiisoft\Form\Helper\HtmlForm;

use function in_array;

abstract class AbstractInputField extends AbstractField
{
    use FormAttributeTrait;

    protected ?string $inputId = null;
    protected ?string $inputIdFromTag = null;
    protected bool $setInputIdAttribute = true;

    protected array $inputTagAttributes = [];

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

    final protected function generateLabel(): string
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

    final protected function generateHint(): string
    {
        return Hint::widget($this->hintConfig)
            ->attribute($this->getFormModel(), $this->attribute)
            ->render();
    }

    final protected function generateError(): string
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
