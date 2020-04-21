<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Form\Exception\InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Form\FormHtml;
use Yiisoft\Widget\Widget;

final class Input extends Widget
{
    use Collection\Options;
    use Collection\InputOptions;
    use Collection\HtmlForm;

    /**
     * Generates an input tag for the given form attribute.
     *
     * @throws InvalidArgumentException
     *
     * @return string the generated input tag.
     */
    public function run(): string
    {
        $this->addId();
        $this->addPlaceholders($this->data, $this->attribute, $this->options);

        $name = $this->addName();
        $value = $this->addValue();

        return Html::input($this->type, $name, $value, $this->options);
    }

    private function addValue(): ?string
    {
        return $this->options['value'] ?? $this->getAttributeValue($this->data, $this->attribute);
    }
}
