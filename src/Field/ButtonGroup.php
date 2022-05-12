<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Yiisoft\Form\Field\Base\PartsField;
use Yiisoft\Html\Tag\Button as ButtonTag;
use Yiisoft\Html\Widget\ButtonGroup as ButtonGroupWidget;

/**
 * Represents a button group widget.
 *
 * @see ButtonGroupWidget
 */
final class ButtonGroup extends PartsField
{
    private ButtonGroupWidget $widget;

    public function __construct()
    {
        $this->widget = ButtonGroupWidget::create()->withoutContainer();
    }

    public function buttons(ButtonTag ...$buttons): self
    {
        $new = clone $this;
        $new->widget = $this->widget->buttons(...$buttons);
        return $new;
    }

    /**
     * @param array $data Array of buttons. Each button is an array with label as first element and additional
     * name-value pairs as attrbiutes of button.
     *
     * Example:
     * ```php
     * [
     *     ['Reset', 'type' => 'reset', 'class' => 'default'],
     *     ['Send', 'type' => 'submit', 'class' => 'primary'],
     * ]
     * ```
     * @param bool $encode Whether button content should be HTML-encoded.
     */
    public function buttonsData(array $data, bool $encode = true): self
    {
        $new = clone $this;
        $new->widget = $this->widget->buttonsData($data, $encode);
        return $new;
    }

    public function buttonAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->widget = $this->widget->buttonAttributes($attributes);
        return $new;
    }

    public function replaceButtonAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->widget = $this->widget->replaceButtonAttributes($attributes);
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-disabled
     */
    public function disabled(bool $disabled = true): self
    {
        $new = clone $this;
        $new->widget = $this->widget->disabled($disabled);
        return $new;
    }

    public function form(?string $formId): self
    {
        $new = clone $this;
        $new->widget = $this->widget->form($formId);
        return $new;
    }

    public function separator(string $separator): self
    {
        $new = clone $this;
        $new->widget = $this->widget->separator($separator);
        return $new;
    }

    protected function generateInput(): string
    {
        $html = $this->widget->render();

        return $html !== ''
            ? "\n" . $html . "\n"
            : '';
    }
}
