<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use Stringable;
use Yiisoft\Html\Tag\Button;

/**
 * @link https://html.spec.whatwg.org/multipage/form-elements.html#the-button-element
 */
abstract class AbstractButtonField extends AbstractSimpleField
{
    use FieldContentTrait;

    private ?Button $button = null;
    private array $attributes = [];

    final public function button(?Button $button): static
    {
        $new = clone $this;
        $new->button = $button;
        return $new;
    }

    final public function attributes(array $attributes): static
    {
        $new = clone $this;
        $new->attributes = array_merge($this->attributes, $attributes);
        return $new;
    }

    final public function replaceAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->attributes = $attributes;
        return $new;
    }

    final public function disabled(?bool $disabled = true): static
    {
        $new = clone $this;
        $new->attributes['disabled'] = $disabled;
        return $new;
    }

    /**
     * Specifies the form element the button belongs to. The value of this attribute must be the ID attribute of a form
     * element in the same document.
     *
     * @param string|null $id ID of a form.
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fae-form
     */
    final public function form(?string $id): static
    {
        $new = clone $this;
        $new->attributes['form'] = $id;
        return $new;
    }

    final protected function generateInput(): string
    {
        $button = ($this->button ?? Button::tag())
            ->type($this->getType());

        if (!empty($this->attributes)) {
            $button = $button->attributes($this->attributes);
        }

        $content = $this->renderContent();
        if ($content !== '') {
            $button = $button->content($content);
        }

        return $button->render();
    }

    abstract protected function getType(): string;
}
