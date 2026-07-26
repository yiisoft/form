<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Yiisoft\Form\Field\Base\ButtonField;
use Yiisoft\Form\Field\Base\PartsField;
use Yiisoft\Html\Tag\Button as ButtonTag;
use Yiisoft\Html\Widget\ButtonGroup as ButtonGroupWidget;

use function array_slice;

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
        $this->widget = (new ButtonGroupWidget())->withoutContainer();
    }

    public function buttons(ButtonTag|ButtonField ...$buttons): self
    {
        $new = clone $this;
        $buttonTags = [];
        foreach ($buttons as $button) {
            $buttonTags[] = $button instanceof ButtonField
                ? $button->getButton()
                : $button;
        }
        $new->widget = $this->widget->buttons(...$buttonTags);
        return $new;
    }

    /**
     * @param array $data Array of buttons. Each button is an array with label as first element and additional
     * name-value pairs as attributes of button.
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

    /**
     * Creates buttons from array data using {@see ButtonField} instances instead of raw tag buttons.
     *
     * Each button is an array with label as first element and additional name-value pairs as attributes.
     * The `type` attribute determines which ButtonField subclass is used:
     * - `reset` → {@see ResetButton}
     * - `submit` → {@see SubmitButton}
     * - default → {@see Button}
     *
     * @param list<array> $data Array of buttons. Each button is an array with label as first element and additional
     * name-value pairs as attributes of button.
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
    public function buttonsFieldData(array $data, bool $encode = true): self
    {
        $buttons = [];
        foreach ($data as $item) {
            $label = (string) ($item[0] ?? '');
            $attributes = array_slice($item, 1, null, true);

            $type = $attributes['type'] ?? 'button';
            unset($attributes['type']);

            $buttonField = match ($type) {
                'reset' => ResetButton::widget(),
                'submit' => SubmitButton::widget(),
                default => Button::widget(),
            };

            $buttonField = $buttonField
                ->content($label)
                ->encodeContent(false)
                ->addButtonAttributes($attributes);

            $buttonTag = $buttonField->getButton();

            if (!$encode) {
                $buttonTag = $buttonTag->encode(false);
            }

            $buttons[] = $buttonTag;
        }

        return $this->buttons(...$buttons);
    }

    public function buttonAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->widget = $this->widget->buttonAttributes($attributes);
        return $new;
    }

    public function addButtonAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->widget = $this->widget->addButtonAttributes($attributes);
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
        return $this->widget->render();
    }
}
