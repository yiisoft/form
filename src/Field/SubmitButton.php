<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Yiisoft\Form\Field\Base\AbstractSimpleField;
use Yiisoft\Html\Tag\Button;

final class SubmitButton extends AbstractSimpleField
{
    private ?Button $button = null;

    public function button(?Button $button): self
    {
        $new = clone $this;
        $new->button = $button;
        return $new;
    }

    protected function generateInput(): string
    {
        $button = $this->button ?? Button::tag();
        $button = $button->type('submit');
        return $button->render();
    }
}
