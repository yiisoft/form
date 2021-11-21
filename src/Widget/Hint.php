<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Html\Tag\CustomTag;

/**
 * The widget for hint form.
 *
 * @psalm-suppress MissingConstructor
 */
final class Hint extends AbstractForm
{
    private ?string $hint = '';
    private string $tag = 'div';

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
        $new = clone $this;

        if ($new->tag === '') {
            throw new InvalidArgumentException('Tag name cannot be empty.');
        }

        if ($new->hint === '') {
            $new->hint = HtmlForm::getAttributeHint($new->getFormModel(), $new->getAttribute());
        }

        return (!empty($new->hint))
            ? CustomTag::name($new->tag)
                ->attributes($new->attributes)
                ->content($new->hint)
                ->encode($new->getEncode())
                ->render()
            : '';
    }
}
