<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

final class Label extends Widget
{
    use Collection\Options;

    /**
     * Generates a label tag for the given form attribute.
     *
     * @return string the generated label tag.
     */
    public function run(): string
    {
        $new = clone $this;

        $new->addPlaceholderOptions($new);

        return Html::label($new->asStringLabel(), $new->asStringFor(), $new->options);
    }
}
