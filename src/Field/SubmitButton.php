<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Stringable;
use Yiisoft\Form\Field\Base\AbstractSimpleField;
use Yiisoft\Html\Tag\Button;

final class SubmitButton extends AbstractSimpleField
{
    private ?Button $button = null;
    private array $attributes = [];
    private int|float|string|Stringable|null $content = null;
    private ?bool $encode = null;
    private bool $doubleEncode = true;

    public function button(?Button $button): self
    {
        $new = clone $this;
        $new->button = $button;
        return $new;
    }

    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = array_merge($this->attributes, $attributes);
        return $new;
    }

    public function replaceAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;
        return $new;
    }

    public function disabled(?bool $disabled = true): self
    {
        $new = clone $this;
        $new->attributes['disabled'] = $disabled;
        return $new;
    }

    public function content(
        int|float|string|Stringable|null $content,
        ?bool $encode = null,
        bool $doubleEncode = true
    ): self {
        $new = clone $this;
        $new->content = $content;
        $new->encode = $encode;
        $new->doubleEncode = $doubleEncode;
        return $new;
    }

    protected function generateInput(): string
    {
        $button = ($this->button ?? Button::tag())->type('submit');

        if (!empty($this->attributes)) {
            $button = $button->attributes($this->attributes);
        }

        if ($this->content !== null) {
            $button = $button
                ->content((string) $this->content)
                ->encode($this->encode)
                ->doubleEncode($this->doubleEncode);
        }

        return $button->render();
    }
}
