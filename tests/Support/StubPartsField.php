<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support;

use Yiisoft\Form\Field\Base\PartsField;

final class StubPartsField extends PartsField
{
    private ?string $inputHtml = null;
    private ?string $beginInputHtml = null;
    private ?string $endInputHtml = null;
    private ?bool $shouldHideLabelValue = null;

    public function setInputHtml(string $html): self
    {
        $this->inputHtml = $html;
        return $this;
    }

    public function setBeginInputHtml(string $html): self
    {
        $this->beginInputHtml = $html;
        return $this;
    }

    public function setEndInputHtml(string $html): self
    {
        $this->endInputHtml = $html;
        return $this;
    }

    public function setShouldHideLabelValue(?bool $value): self
    {
        $this->shouldHideLabelValue = $value;
        return $this;
    }

    protected function shouldHideLabel(): bool
    {
        return $this->shouldHideLabelValue ?? parent::shouldHideLabel();
    }

    protected function generateInput(): string
    {
        return $this->inputHtml ?? parent::generateInput();
    }

    protected function generateBeginInput(): string
    {
        return $this->beginInputHtml ?? parent::generateBeginInput();
    }

    protected function generateEndInput(): string
    {
        return $this->endInputHtml ?? parent::generateEndInput();
    }
}
