<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Attribute;

use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

abstract class ButtonAttributes extends Widget
{
    use GlobalAttributes;

    /**
     * Set whether the element is disabled or not.
     *
     * If this attribute is set to `true`, the element is disabled. Disabled elements are usually drawn with grayed-out
     * text.
     * If the element is disabled, it does not respond to user actions, it cannot be focused, and the command event
     * will not fire. In the case of form elements, it will not be submitted. Do not set the attribute to true, as
     * this will suggest you can set it to `false` to enable the element again, which is not the case.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-disabledformelements-disabled
     */
    public function disabled(): self
    {
        $new = clone $this;
        $new->attributes['disabled'] = true;
        return $new;
    }

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
    public function form(string $value): self
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
