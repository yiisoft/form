<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Html\Tag\CustomTag;

/**
 * The widget for hint form.
 */
final class Hint extends Widget
{
    /**
     * Generates a hint tag for the given form attribute.
     *
     * @return string the generated hint tag.
     */
    protected function run(): string
    {
        $new = clone $this;

        /** @var string */
        $hint = $new->attributes['hint'] ?? $new->getAttributeHint();

        /** @var string */
        $tag = $new->attributes['tag'] ?? 'div';

        unset($new->attributes['hint'], $new->attributes['tag']);

        return $hint !== ''
            ? CustomTag::name($tag)->attributes($new->attributes)->content($hint)->render()
            : '';
    }
}
