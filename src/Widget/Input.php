<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

final class Input extends Widget
{
    use Collection\Options;
    use Collection\InputOptions;

    /**
     * Generates an input tag for the given form attribute.
     *
     * @return string the generated input tag.
     */
    public function run(): string
    {
        $this->addId();
        $this->options = HtmlForm::addPlaceholders($this->data, $this->attribute, $this->options);

        $name = $this->addName();
        $value = $this->addValue();

        return Html::input($this->type, $name, $value, $this->options);
    }

    private function addValue(): ?string
    {
        return $this->options['value'] ?? HtmlForm::getAttributeValue($this->data, $this->attribute);
    }
}
