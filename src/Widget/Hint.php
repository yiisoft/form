<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

final class Hint extends Widget
{
    use Collection\Options;

    /**
     * Generates a hint tag for the given form attribute.
     *
     * @return string the generated hint tag.
     */
    public function run(): string
    {
        $hint = $this->addhint();

        if (!empty($hint)) {
            $tag = ArrayHelper::remove($this->options, 'tag', 'div');
            unset($this->options['hint']);

            return Html::tag($tag, $hint, $this->options);
        }

        return $hint;
    }
}
