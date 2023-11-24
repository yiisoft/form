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
            $this->getInputData()->getName(),
            (string) $this->getInputData()->getValue(),
            $this->getInputAttributes()
        )->render();
    }
}
