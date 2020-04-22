<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

final class Label extends Widget
{
    use Collection\Options;
    use Collection\HtmlForm;

    /**
     * Generates a label tag for the given form attribute.
     *
     * @return string the generated label tag.
     */
    public function run(): string
    {
        $for = ArrayHelper::remove(
            $this->options,
            'for',
            $this->addInputId($this->data, $this->attribute, $this->charset)
        );

        $label = ArrayHelper::remove(
            $this->options,
            'label',
            Html::encode($this->data->getAttributeLabel($this->attribute))
        );

        return Html::label($label, $for, $this->options);
    }
}
