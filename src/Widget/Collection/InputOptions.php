<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Collection;

use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Html\Html;

trait InputOptions
{
    private bool $autofocus = false;
    private bool $ariaAttribute = true;
    private bool $disabled = false;
    private ?string $inputId = null;
    private array $inputOptions = [];
    private array $labelOptions = ['class' => 'control-label'];
    private int $maxlength = 0;
    private ?string $placeholder = null;
    private bool $required = true;
    private int $size = 0;
    private ?string $tabindex = null;

    protected function configInputOptions(array $options = []): void
    {
        $this->adjustLabelFor($options);
        $this->addAutofocus($options);
        $this->addDisabled($options);
        $this->addMaxLength($options);
        $this->addPlaceholder($options);
        $this->addRequired($options);
        $this->addTabIndex($options);
        $this->addSize($options);
    }

    public function autofocus(bool $value): self
    {
        $new = clone $this;
        $new->autofocus = $value;
        return $new;
    }

    public function ariaAttribute(bool $value): self
    {
        $new = clone $this;
        $new->ariaAttribute = $value;
        return $new;
    }

    public function disabled(bool $value): self
    {
        $new = clone $this;
        $new->disabled = $value;
        return $new;
    }

    public function inputOptions(array $value): self
    {
        $new = clone $this;
        $new->inputOptions = $value;
        return $new;
    }

    public function maxlength(int $value): self
    {
        $new = clone $this;
        $new->maxlength = $value;
        return $new;
    }

    public function placeholder(string $value): self
    {
        $new = clone $this;
        $new->placeholder = $value;
        return $new;
    }

    public function required(bool $value): self
    {
        $new = clone $this;
        $new->required = $value;
        return $new;
    }

    public function size(int $value): self
    {
        $new = clone $this;
        $new->size = $value;
        return $new;
    }

    public function tabindex(string $value): self
    {
        $new = clone $this;
        $new->tabindex = $value;
        return $new;
    }

    private function addAutofocus(array $options = []): void
    {
        if (!isset($options['autofocus']) && $this->autofocus) {
            $this->inputOptions['autofocus'] = $this->autofocus;
        }
    }

    public function addInputId(): string
    {
        return $this->inputId ?: HtmlForm::getInputId($this->data, $this->attribute);
    }

    private function adjustLabelFor(array $options = []): void
    {
        if (!isset($options['id'])) {
            return;
        }

        $this->inputId = $options['id'];

        if (!isset($this->labelOptions['for'])) {
            $this->labelOptions['for'] = $options['id'];
        }
    }

    private function addDisabled(array $options = []): void
    {
        if (!isset($options['disabled'])) {
            $this->inputOptions['disabled'] = $this->disabled;
        }
    }

    private function addMaxLength(array $options = []): void
    {
        if (!isset($options['maxlength']) && $this->maxlength > 0) {
            $this->inputOptions['maxlength'] = $this->maxlength;
        }
    }

    private function addPlaceholder(array $options = []): void
    {
        if (!isset($options['placeholder']) && $this->placeholder !== null) {
            $this->inputOptions['placeholder'] = $this->placeholder;
        }
    }

    private function addRequired(array $options = []): void
    {
        $this->inputOptions['required'] = $options['required'] ?? $this->required;
    }

    private function addTabIndex(array $options = []): void
    {
        if (!isset($options['tabindex']) && $this->tabindex) {
            $this->inputOptions['tabindex'] = $this->tabindex;
        }
    }

    private function addSize(array $options = []): void
    {
        if (!isset($options['size']) && $this->size > 0) {
            $this->inputOptions['size'] = $this->size;
        }
    }
}
