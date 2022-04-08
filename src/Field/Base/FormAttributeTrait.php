<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use InvalidArgumentException;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;

trait FormAttributeTrait
{
    private ?FormModelInterface $formModel = null;
    private string $attribute = '';

    final public function attribute(FormModelInterface $formModel, string $attribute): static
    {
        $new = clone $this;
        $new->formModel = $formModel;
        $new->attribute = $attribute;
        return $new;
    }

    final protected function getFormModel(): FormModelInterface
    {
        if ($this->formModel === null) {
            throw new InvalidArgumentException('Form model is not set.');
        }

        return $this->formModel;
    }

    final protected function hasFormModelAndAttribute(): bool
    {
        return $this->formModel !== null && $this->attribute !== '';
    }

    final protected function getAttributeName(): string
    {
        return HtmlForm::getAttributeName($this->getFormModel(), $this->attribute);
    }

    final protected function getAttributeValue(): mixed
    {
        return HtmlForm::getAttributeValue($this->getFormModel(), $this->attribute);
    }

    final protected function getAttributeLabel(): string
    {
        return HtmlForm::getAttributeLabel($this->getFormModel(), $this->attribute);
    }

    final protected function getAttributeHint(): string
    {
        return HtmlForm::getAttributeHint($this->getFormModel(), $this->attribute);
    }

    final protected function getAttributePlaceholder(): ?string
    {
        $placeholder = $this->getFormModel()->getAttributePlaceholder($this->getAttributeName());
        return $placeholder === '' ? null : $placeholder;
    }

    final protected function getInputId(): string
    {
        return HtmlForm::getInputId($this->getFormModel(), $this->attribute);
    }

    final protected function getFirstError(): ?string
    {
        return $this->getFormModel()->getFormErrors()->getFirstError($this->getAttributeName());
    }
}
