<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\FieldPart;

use InvalidArgumentException;
use Yiisoft\Form\Exception\AttributeNotSetException;
use Yiisoft\Form\Exception\FormModelNotSetException;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Widget\Widget;

/**
 * The widget for hint form.
 *
 * @psalm-suppress MissingConstructor
 */
final class Hint extends Widget
{
    private string $attribute = '';
    private array $attributes = [];
    private bool $encode = false;
    private ?string $hint = '';
    private string $tag = 'div';
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
     * Set the ID of the widget.
     *
     * @param string|null $id
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/dom.html#the-id-attribute
     */
    public function id(?string $id): self
    {
        $new = clone $this;
        $new->attributes['id'] = $id;
        return $new;
    }

    /**
     * Set hint text.
     *
     * @param string|null $value
     *
     * @return static
     */
    public function hint(?string $value): self
    {
        $new = clone $this;
        $new->hint = $value;
        return $new;
    }

    /**
     * Set the container tag name for the hint.
     *
     * @param string $value Container tag name. Set to empty value to render error messages without container tag.
     *
     * @return static
     */
    public function tag(string $value): self
    {
        $new = clone $this;
        $new->tag = $value;
        return $new;
    }

    /**
     * Generates a hint tag for the given form attribute.
     *
     * @return string the generated hint tag.
     */
    protected function run(): string
    {
        $hint = $this->hint;

        if ($this->tag === '') {
            throw new InvalidArgumentException('Tag name cannot be empty.');
        }

        if ($hint === '') {
            $hint = HtmlForm::getAttributeHint($this->getFormModel(), $this->getAttribute());
        }

        return $hint !== null && $hint !== ''
            ? CustomTag::name($this->tag)
                ->attributes($this->attributes)
                ->content($hint)
                ->encode($this->encode)
                ->render()
            : '';
    }

    private function getAttribute(): string
    {
        if ($this->attribute === '') {
            throw new AttributeNotSetException('Failed to create widget because attribute is not set.');
        }

        return $this->attribute;
    }

    private function getFormModel(): FormModelInterface
    {
        if ($this->formModel === null) {
            throw new FormModelNotSetException('Failed to create widget because form model is not set.');
        }

        return $this->formModel;
    }
}
