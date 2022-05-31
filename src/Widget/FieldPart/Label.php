<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\FieldPart;

use Yiisoft\Form\Exception\AttributeNotSetException;
use Yiisoft\Form\Exception\FormModelNotSetException;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Html\Tag\Label as LabelTag;
use Yiisoft\Widget\Widget;

/**
 * Generates a label tag for the given form attribute.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/label.html
 */
final class Label extends Widget
{
    private string $attribute = '';
    private array $attributes = [];
    private bool $encode = false;
    private ?string $label = '';
    private ?FormModelInterface $formModel = null;

    /**
     * The HTML attributes. The following special options are recognized.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return static
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function attributes(array $values): self
    {
        $new = clone $this;
        $new->attributes = array_merge($new->attributes, $values);
        return $new;
    }

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

    /**
     * The id of a labelable form-related element in the same document as the tag label element.
     *
     * The first element in the document with an id matching the value of the for attribute is the labeled control for
     * this label element, if it is a labelable element.
     *
     * @param string|null $value The id of a labelable form-related element in the same document as the tag label
     * element. If null, the attribute will be removed.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/label.html#label.attrs.for
     */
    public function forId(?string $value): self
    {
        $new = clone $this;
        $new->attributes['for'] = $value;
        return $new;
    }

    /**
     * This specifies the label to be displayed.
     *
     * @param string|null $value The label to be displayed.
     *
     * @return static
     *
     * Note that this will NOT be encoded.
     * - If this is not set, {@see \Yiisoft\Form\FormModel::getAttributeLabel() will be called to get the label for
     * display (after encoding).
     */
    public function label(?string $value): self
    {
        $new = clone $this;
        $new->label = $value;
        return $new;
    }

    /**
     * @return string the generated label tag.
     */
    protected function run(): string
    {
        $attributes = $this->attributes;
        $label = $this->label;

        if ($label === '') {
            $label = HtmlForm::getAttributeLabel($this->getFormModel(), $this->getAttribute());
        }

        /** @var string */
        if (!array_key_exists('for', $attributes)) {
            $attributes['for'] = HtmlForm::getInputId($this->getFormModel(), $this->getAttribute());
        }

        return $label !== null ?
            LabelTag::tag()
                ->attributes($attributes)
                ->content($label)
                ->encode($this->encode)
                ->render()
            : '';
    }

    private function getAttribute(): string
    {
        if ($this->attribute === '') {
            throw new AttributeNotSetException();
        }

        return $this->attribute;
    }

    /**
     * Return FormModelInterface object.
     *
     * @return FormModelInterface
     */
    private function getFormModel(): FormModelInterface
    {
        if ($this->formModel === null) {
            throw new FormModelNotSetException();
        }

        return $this->formModel;
    }
}
