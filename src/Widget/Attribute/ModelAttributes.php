<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Attribute;

use InvalidArgumentException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;

trait ModelAttributes
{
    private array $attributes = [];
    private string $attribute = '';
    private string $charset = 'UTF-8';
    private ?string $id = '';
    private ?FormModelInterface $formModel = null;

    /**
     * Set the character set used to generate the widget id. See {@see HtmlForm::getInputId()}.
     *
     * @param string $value
     *
     * @return static
     */
    public function charset(string $value): self
    {
        $new = clone $this;
        $new->charset = $value;
        return $new;
    }

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
    public function config(FormModelInterface $formModel, string $attribute, array $attributes = []): self
    {
        $new = clone $this;
        $new->formModel = $formModel;
        $new->attribute = $attribute;
        $new->attributes = $attributes;
        return $new;
    }

    /**
     * Set the ID of the widget.
     *
     * @param string|null $value The ID of the widget. `null` means that the attribute will be removed.
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#the-id-attribute
     */
    public function id(?string $value): self
    {
        $new = clone $this;
        $new->id = $value;
        return $new;
    }

    protected function getFormModel(): FormModelInterface
    {
        if ($this->formModel === null) {
            throw new InvalidArgumentException('Form model is not set.');
        }

        return $this->formModel;
    }

    /**
     * Generates a unique ID for the attribute.
     *
     * @return string|null
     */
    protected function getId(): ?string
    {
        /** @var string */
        $id = ArrayHelper::remove($this->attributes, 'id', $this->id);

        return $id === '' ? HtmlForm::getInputId($this->getFormModel(), $this->attribute, $this->charset) : $id;
    }
}
