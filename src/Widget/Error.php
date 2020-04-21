<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

final class Error extends Widget
{
    use Collection\Options;

    /**
     * Generates a tag that contains the first validation error of the specified form attribute.
     *
     * @return string the generated label tag
     */
    public function run(): string
    {
        $errorSource = ArrayHelper::remove($this->options, 'errorSource');

        if ($errorSource !== null) {
            $error = $errorSource($this->data, $this->attribute);
        } else {
            $error = $this->data->getFirstError($this->attribute);
        }

        $tag = ArrayHelper::remove($this->options, 'tag', 'div');
        $encode = ArrayHelper::remove($this->options, 'encode', true);

        return Html::tag($tag, $encode ? Html::encode($error) : $error, $this->options);
    }
}
