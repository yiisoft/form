<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Html\Tag\Label as LabelTag;

/**
 * Generates a label tag for the given form attribute.
 *
 * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/label.html
 */
final class Label extends Widget
{
    private string $label = '';

    /**
     * The id of a labelable form-related element in the same document as the tag label element.
     *
     * The first element in the document with an id matching the value of the for attribute is the labeled control for
     * this label element, if it is a labelable element.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://www.w3.org/TR/2012/WD-html-markup-20120329/label.html#label.attrs.for
     */
    public function for(string $value): self
    {
        $new = clone $this;
        $new->attributes['for'] = $value;
        return $new;
    }

    /**
     * This specifies the label to be displayed.
     *
     * @param string $value
     *
     * @return static
     *
     * Note that this will NOT be encoded.
     * - If this is not set, {@see \Yii\Extension\Simple\Forms\BaseModel::getAttributeLabel() will be called to get the
     * label for display (after encoding).
     */
    public function label(string $value): self
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
        $new = clone $this;

        /** @var string */
        $for = $new->attributes['for'] ?? $new->getId();

        $label = $new->label === '' ? $new->getLabel() : $new->label;

        return LabelTag::tag()->attributes($new->attributes)->content($label)->forId($for)->render();
    }
}
