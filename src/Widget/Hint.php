<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

final class Hint extends Widget
{
    /**
     * Generates a hint tag for the given form attribute.
     *
     * @return string the generated hint tag.
     */
    public function run(): string
    {
        $hint = $this->options['hint'] ?? $this->data->getAttributeHint($this->attribute);

        if (empty($hint)) {
            return '';
        }

        $tag = ArrayHelper::remove($this->options, 'tag', 'div');
        unset($this->options['hint']);

        return Html::tag($tag, $hint, $this->options);
    }
}
