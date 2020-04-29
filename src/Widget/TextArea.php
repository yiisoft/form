<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

final class TextArea extends Widget
{
    use Collection\Options;
    use Collection\InputOptions;

    /**
     * Generates a textarea tag for the given form attribute.
     *
     * @return string the generated textarea tag.
     */
    public function run(): string
    {
        $new = clone $this;

        $new->placeholderOptions($new);

        if (!empty($new->addId())) {
            $new->options['id'] = $new->addId();
        }

        return Html::textarea($new->addName(), $new->addValue(), $new->options);
    }
}
