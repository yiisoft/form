<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Html\Tag\Label as LabelTag;
use Yiisoft\Widget\Widget;

/**
 * Generates a label tag for the given form attribute.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/label.html
 *
 * @psalm-suppress MissingConstructor
 */
final class Label extends Widget
{
    private string $attribute = '';
    private ?string $for = '';
    private bool $encode = true;
    private FormModelInterface $formModel;
    private ?string $label = '';
    private array $tagAttributes = [];

    /**
     * Specify a form, its attribute.
     *
     * @param FormModelInterface $formModel Form instance.
     * @param string $attribute Form model's property name this widget is rendered for.
     *
     * @return static
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function config(FormModelInterface $formModel, string $attribute): self
    {
        $new = clone $this;
        $new->formModel = $formModel;
        $new->attribute = $attribute;
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
    public function for(?string $value): self
    {
        $new = clone $this;
        $new->for = $value;
        return $new;
    }

    /**
     * This specifies the label to be displayed.
     *
     * @param string $value The label to be displayed.
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
     * HTML attributes for the widget container tag.
     *
     * @param array $value
     *
     * @return static
     *
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function tagAttributes(array $value): self
    {
        $new = clone $this;
        $new->tagAttributes = $value;
        return $new;
    }

    /**
     * @return string the generated label tag.
     */
    protected function run(): string
    {
        $new = clone $this;

        if ($new->label === '') {
            $new->label = HtmlForm::getAttributeLabel($new->formModel, $new->attribute);
        }

        if ($new->for === '') {
            $new->for = HtmlForm::getInputId($new->formModel, $new->attribute);
        }

        return $new->label !== null
            ? LabelTag::tag()
                ->attributes($new->tagAttributes)
                ->content($new->label)
                ->encode($new->encode)
                ->forId($new->for)
                ->render()
            : '';
    }
}
