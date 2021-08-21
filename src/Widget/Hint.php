<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
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

        /** @var bool */
        $encode = $new->attributes['encode'] ?? false;

        /** @var bool|string */
        $hint = ArrayHelper::remove($new->attributes, 'hint', $new->getHint());

        /** @psalm-var non-empty-string */
        $tag = $new->attributes['tag'] ?? 'div';

        unset($new->attributes['hint'], $new->attributes['tag']);

        return (!is_bool($hint) && $hint !== '')
            ? CustomTag::name($tag)->attributes($new->attributes)->content($hint)->encode($encode)->render()
            : '';
    }
}
