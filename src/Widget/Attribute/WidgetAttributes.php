<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Attribute;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Form\Helper\HtmlFormErrors;
use Yiisoft\Widget\Widget;

abstract class WidgetAttributes extends Widget
{
    use GlobalAttributes;

    private string $attribute = '';
    private bool $encode = true;
    private ?FormModelInterface $formModel = null;

    /**
     * Whether content should be HTML-encoded.
     *
     * @param bool $value
     *
     * @return static
     */
    public function encode(bool $value): self
    {
        $new = clone $this;
        $new->encode = $value;
        return $new;
    }

    /**
     * @return static
     */
    public function for(FormModelInterface $formModel, string $attribute): self
    {
        $new = clone $this;
        $new->formModel = $formModel;
        $new->attribute = $attribute;
        return $new;
    }

    protected function getAttribute(): string
    {
        if ($this->attribute === '') {
            throw new InvalidArgumentException('Attribute is not set.');
        }

        return $this->attribute;
    }

    /**
     * Generate hint attribute.
     *
     * @return string
     */
    protected function getAttributeHint(): string
    {
        return HtmlForm::getAttributeHint($this->getFormModel(), $this->getAttribute());
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
    public function getAttributePlaceHolder(): string
    {
        return HtmlForm::getAttributePlaceHolder($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Return value of attribute.
     *
     * @return bool|float|int|iterable|object|string|Stringable|null
     */
    protected function getAttributeValue()
    {
        return HtmlForm::getAttributeValue($this->getFormModel(), $this->getAttribute());
    }

    protected function getEncode(): bool
    {
        return $this->encode;
    }

    /**
     * Return FormModelInterface object.
     *
     * @return FormModelInterface
     */
    protected function getFormModel(): FormModelInterface
    {
        if ($this->formModel === null) {
            throw new InvalidArgumentException('Form model is not set.');
        }

        return $this->formModel;
    }

    /**
     * Generate input id attribute.
     */
    public function getInputId(): string
    {
        return HtmlForm::getInputId($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Generate input name attribute.
     *
     * @return string
     */
    public function getInputName(): string
    {
        return HtmlForm::getInputName($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Return if there is a validation error in the attribute.
     */
    public function hasError(): bool
    {
        return HtmlFormErrors::hasErrors($this->getFormModel(), $this->getAttribute());
    }

    /**
     * Return if the field was validated.
     *
     * @return bool
     */
    public function isValidated(): bool
    {
        return $this->getFormModel()->isValidated();
    }
}
