<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support;

use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Html\Html;

final class StubInputField extends InputField
{
    protected function generateInput(): string
    {
        return Html::textInput(
            $this->getInputName(),
            (string) $this->getAttributeValue(),
            $this->getInputTagAttributes()
        )->render();
    }
}
