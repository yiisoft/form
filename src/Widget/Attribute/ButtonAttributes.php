<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Attribute;

use Yiisoft\Html\Html;

abstract class ButtonAttributes extends GlobalAttributes
{
    /**
     * Specifies the form element the tag input element belongs to. The value of this attribute must be the id
     * attribute of a {@see Form} element in the same document.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fae-form
     */
    public function form(string $value): static
    {
        $new = clone $this;
        $new->attributes['form'] = $value;
        return $new;
    }

    /**
     * Set build attributes for the widget.
     *
     * @param array $attributes $value
     * @param string $suffix The suffix of the attribute name.
     *
     * @return array
     */
    protected function build(array $attributes, string $suffix): array
    {
        $id = Html::generateId('w') . $suffix;

        if (!array_key_exists('id', $attributes)) {
            $attributes['id'] = $id;
        }

        if (!array_key_exists('name', $attributes)) {
            $attributes['name'] = $id;
        }

        return $attributes;
    }
}
