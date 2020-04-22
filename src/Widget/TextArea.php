<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Form\Helper\HtmlForm;
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
        $this->addId();
        $this->options = HtmlForm::addPlaceholders($this->data, $this->attribute, $this->options);

        $name = $this->addName();
        $value = $this->addValue();

        return Html::textarea($name, $value, $this->options);
    }

    private function addValue(): string
    {
        $value = $this->options['value'] ?? HtmlForm::getAttributeValue($this->data, $this->attribute);

        unset($this->options['value']);

        return $value;
    }
}
