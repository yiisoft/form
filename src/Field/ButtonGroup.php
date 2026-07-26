<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Yiisoft\Form\Field\Base\ButtonField;
use Yiisoft\Form\Field\Base\PartsField;
use Yiisoft\Form\Theme\ThemeContainer;
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
     * @param bool $themed When true, creates buttons via {@see ButtonField} instances
     * ({@see Button}, {@see ResetButton}, {@see SubmitButton}) instead of raw tag buttons.
     * The `type` attribute determines which subclass is used:
     * `reset` → {@see ResetButton}, `submit` → {@see SubmitButton}, default → {@see Button}.
     * If label is null, the content from the theme is used.
     * Theme styling only applies when the host application has configured a theme via
     * {@see ThemeContainer}. Without a configured theme, the output is identical to the
     * default (non-themed) behavior.
     *
     * In a future major version, the default value of this parameter will change to `true`.
     */
    public function buttonsData(array $data, bool $encode = true, bool $themed = false): self
    {
        $factory = $themed
            ? static function (array $item, bool $encode): ButtonTag {
                $label = $item[0] ?? null;
                $attributes = array_slice($item, 1, null, true);

                $type = $attributes['type'] ?? 'button';
                unset($attributes['type']);

                $buttonField = match ($type) {
                    'reset' => ResetButton::widget(),
                    'submit' => SubmitButton::widget(),
                    default => Button::widget(),
                };

                if ($label !== null) {
                    $buttonField = $buttonField->content((string) $label);
                }

                return $buttonField
                    ->encodeContent(false)
                    ->addButtonAttributes($attributes)
                    ->getButton()
                    ->encode($encode);
            }
            : null;

        $new = clone $this;
        $new->widget = $this->widget->buttonsData($data, $encode, $factory);
        return $new;
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
