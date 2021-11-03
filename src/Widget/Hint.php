<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
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
    private array $attributes = [];
    private string $attribute = '';
    private bool $encode = true;
    private ?string $hint = '';
    private string $tag = 'div';
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
    public function config(FormModelInterface $formModel, string $attribute, array $attributes = []): self
    {
        $new = clone $this;
        $new->formModel = $formModel;
        $new->attribute = $attribute;
        $new->attributes = $attributes;
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
     * Empty to render error messages without container {@see Html::tag()}.
     *
     * @param string $value
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
        $new = clone $this;

        if ($new->hint !== null && $new->hint === '') {
            $new->hint = HtmlForm::getAttributeHint($new->formModel, $new->attribute);
        }

        if ($new->tag === '') {
            throw new InvalidArgumentException('Tag name cannot be empty.');
        }

        return (!empty($new->hint))
            ? CustomTag::name($new->tag)
                ->attributes($new->attributes)
                ->content($new->hint)
                ->encode($new->encode)
                ->render()
            : '';
    }
}
