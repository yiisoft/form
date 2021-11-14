<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Yiisoft\Form\Field\InputText;

final class FieldFactory
{
    private ?string $template = null;

    public function setTemplate(?string $template): void
    {
        $this->template = $template;
    }

    public function text(FormModelInterface $formModel, string $attribute): InputText
    {
        $widget = InputText::widget()->attribute($formModel, $attribute);

        if ($this->template !== null) {
            $widget = $widget->template($this->template);
        }

        return $widget;
    }
}
