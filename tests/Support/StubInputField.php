<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support;

use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Html\Html;

final class StubInputField extends InputField
{
    protected function generateInput(): string
    {
        /**
         * Dirty hack to escape fake mutant.
         */
        $attributes = [];
        $this->prepareInputAttributes($attributes);

        return Html::textInput(
            $this->getName(),
            (string) $this->getValue(),
            $this->getInputAttributes(),
        )->render();
    }
}
