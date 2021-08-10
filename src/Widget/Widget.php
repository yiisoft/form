<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Html\NoEncodeStringableInterface;
use Yiisoft\Widget\Widget as AbstractWidget;

abstract class Widget extends AbstractWidget implements NoEncodeStringableInterface
{
    protected array $attributes = [];
    private string $attribute = '';
    private string $charset = 'UTF-8';
    private string $id = '';
    private FormModelInterface $formModel;

    /**
     * Set form interface, attribute name and attributes, and attributes for the widget.
     *
     * @param FormModelInterface $formModel Form.
     * @param string $attribute Form model property this widget is rendered for.
     * @param array $attributes The HTML attributes for the widget container tag.
     *
     * @return static
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    final public function config(FormModelInterface $formModel, string $attribute, array $attributes = []): self
    {
        $new = clone $this;
        $new->formModel = $formModel;
        $new->attribute = $attribute;
        $new->attributes = $attributes;
        return $new;
    }

    /**
     * Set the character set used to generate the widget id. See {@see HtmlForm::getInputId()}.
     *
     * @param string $value
     *
     * @return static
     */
    final public function charset(string $value): self
    {
        $new = clone $this;
        $new->charset = $value;
        return $new;
    }

    /**
     * Set the Id of the widget.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#the-id-attribute
     */
    final public function id(string $value): self
    {
        $new = clone $this;
        $new->id = $value;
        return $new;
    }

    /**
     * Return the attribute form model.
     *
     * @return string
     */
    protected function getAttribute(): string
    {
        return $this->attribute;
    }

    /**
     * Return the attribute hint for the model.
     *
     * @return string
     */
    protected function getAttributeHint(): string
    {
        return $this->formModel->getAttributeHint($this->getAttributeName());
    }

    /**
     * Return the attribute first error message.
     *
     * @return string
     */
    protected function getFirstError(): string
    {
        return $this->formModel->getFirstError($this->getAttributeName());
    }

    /**
     * Return the model interface.
     *
     * @return FormModelInterface
     */
    protected function getFormModel(): FormModelInterface
    {
        return $this->formModel;
    }

    /**
     * Return the imput id.
     *
     * @return string
     */
    protected function getId(): string
    {
        $new = clone $this;

        /** @var string */
        $id = $new->attributes['id'] ?? $new->id;

        return $id === '' ? HtmlForm::getInputId($new->formModel, $new->attribute) : $id;
    }

    /**
     * Return the input name.
     *
     * @return string the generated input name.
     */
    protected function getInputName(): string
    {
        return HtmlForm::getInputName($this->formModel, $this->attribute);
    }

    /**
     * Return the attribute label.
     *
     * @return string
     */
    protected function getLabel(): string
    {
        return $this->formModel->getAttributeLabel($this->getAttributeName());
    }

    /**
     * Return the attribute value.
     *
     * @return scalar|iterable|object|Stringable|null
     */
    protected function getValue()
    {
        return $this->formModel->getAttributeValue($this->getAttributeName());
    }

    /**
     * Returns the real attribute name from the given attribute expression.
     *
     * If `$attribute` has neither prefix nor suffix, it will be returned back without change.
     *
     * @throws InvalidArgumentException if the attribute name contains non-word characters.
     *
     * @return string the attribute name without prefix and suffix.
     *
     * {@see parseAttribute()}
     */
    private function getAttributeName(): string
    {
        return HtmlForm::getAttributeName($this->attribute);
    }
}
