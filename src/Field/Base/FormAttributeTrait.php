<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;

trait FormAttributeTrait
{
    private ?FormModelInterface $formModel = null;
    private string $attribute = '';

    /**
     * @return static
     */
    final public function attribute(FormModelInterface $formModel, string $attribute): self
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

    /**
     * @return bool|float|int|iterable|object|string|Stringable|null
     */
    final protected function getAttributeValue()
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
        return $this->getFormModel()->getAttributePlaceholder($this->attribute);
    }

    final protected function getInputId(): string
    {
        return HtmlForm::getInputId($this->getFormModel(), $this->attribute);
    }
}
