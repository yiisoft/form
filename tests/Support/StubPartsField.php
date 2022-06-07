<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support;

use Yiisoft\Form\Field\Base\PartsField;

final class StubPartsField extends PartsField
{
    private ?string $inputHtml = null;

    public function setInputHtml(string $html): self
    {
        $this->inputHtml = $html;
        return $this;
    }

    protected function generateInput(): string
    {
        return $this->inputHtml ?? parent::generateInput();
    }
}
