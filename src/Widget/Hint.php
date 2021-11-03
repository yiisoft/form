<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Form\Widget\Attribute\ModelAttributes;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Widget\Widget;

/**
 * The widget for hint form.
 */
final class Hint extends Widget
{
    use ModelAttributes;

    private bool $encode = true;
    private ?string $hint = '';
    private string $tag = 'div';

    /**
     * Whether content should be HTML-encoded.
     *
     * @param bool $value
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
            $new->hint = HtmlForm::getAttributeHint($new->getFormModel(), $new->attribute);
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
