<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Field\Part\Label;

abstract class AbstractSimpleField extends AbstractField
{
    final protected function generateLabel(): string
    {
        return Label::widget($this->labelConfig)->render();
    }

    final protected function generateHint(): string
    {
        return Hint::widget($this->hintConfig)->render();
    }

    final protected function generateError(): string
    {
        return Error::widget($this->errorConfig)->render();
    }
}
