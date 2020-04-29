<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

final class Hint extends Widget
{
    use Options\Common;

    /**
     * Generates a hint tag for the given form attribute.
     *
     * @return string the generated hint tag.
     */
    public function run(): string
    {
        $hint = ArrayHelper::remove($this->options, 'hint', $this->data->attributeHint($this->attribute));

        if (empty($hint)) {
            return '';
        }

        $tag = ArrayHelper::remove($this->options, 'tag', 'div');
        return Html::tag($tag, $hint, $this->options);
    }
}
