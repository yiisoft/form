<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Attribute;

use Yiisoft\Form\Exception\AttributeNotSetException;
use Yiisoft\Form\Exception\FormModelNotSetException;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Form\Helper\HtmlFormErrors;

abstract class WidgetAttributes extends GlobalAttributes
{
    private string $attribute = '';
    private ?FormModelInterface $formModel = null;

    public function for(FormModelInterface $formModel, string $attribute): static
    {
        $new = clone $this;
        $new->formModel = $formModel;
        $new->attribute = $attribute;
        return $new;
    }

    protected function getAttribute(): string
    {
        if ($this->attribute === '') {
            throw new AttributeNotSetException();
        }

        return $this->attribute;
    }

    /**
     * Generate label attribute.
     *
     * @return string
     */
    protected function getAttributeLabel(): string
    {
        return HtmlForm::getAttributeLabel($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Generate placeholder attribute.
     *
     * @return string
     */
    protected function getAttributePlaceHolder(): string
    {
        return HtmlForm::getAttributePlaceHolder($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Return value of attribute.
     *
     * @return mixed
     */
    protected function getAttributeValue(): mixed
    {
        return HtmlForm::getAttributeValue($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Return FormModelInterface object.
     *
     * @return FormModelInterface
     */
    protected function getFormModel(): FormModelInterface
    {
        if ($this->formModel === null) {
            throw new FormModelNotSetException();
        }

        return $this->formModel;
    }

    /**
     * Generate input id attribute.
     *
     * @return string
     */
    protected function getInputId(): string
    {
        return HtmlForm::getInputId($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Generate input name attribute.
     *
     * @return string
     */
    protected function getInputName(): string
    {
        return HtmlForm::getInputName($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Return if there is a validation error in the attribute.
     *
     * @return bool
     */
    protected function hasError(): bool
    {
        return HtmlFormErrors::hasErrors($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Return if the field was validated.
     *
     * @return bool
     */
    protected function isValidated(): bool
    {
        return $this->getFormModel()->isValidated();
    }
}
