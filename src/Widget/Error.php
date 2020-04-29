<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

final class Error extends Widget
{
    use Options\Common;

    /**
     * Generates a tag that contains the first validation error of the specified form attribute.
     *
     * @return string the generated label tag
     */
    public function run(): string
    {
        $new = clone $this;

        $errorSource = ArrayHelper::remove($new->options, 'errorSource');

        if ($errorSource !== null) {
            $error = $errorSource($new->data, $new->attribute);
        } else {
            $error = $new->data->firstError($new->attribute);
        }

        $tag = ArrayHelper::remove($new->options, 'tag', 'div');
        $encode = ArrayHelper::remove($new->options, 'encode', true);

        return Html::tag($tag, $encode ? Html::encode($error) : $error, $new->options);
    }
}
