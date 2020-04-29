<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

final class Label extends Widget
{
    use Options\Common;

    /**
     * Generates a label tag for the given form attribute.
     *
     * @return string the generated label tag.
     */
    public function run(): string
    {
        $new = clone $this;

        $new->setPlaceholderOptions();

        $for = ArrayHelper::remove(
            $new->options,
            'for',
            HtmlForm::getInputId($new->data, $new->attribute, $new->charset)
        );

        return Html::label($new->getLabelAndRemoveItFromOptions(), $for, $new->options);
    }
}
