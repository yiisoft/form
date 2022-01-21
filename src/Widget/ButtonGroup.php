<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Form\Widget\Attribute\ButtonAttributes;
use Yiisoft\Html\Tag\Input;
use Yiisoft\Html\Tag\Div;

use function implode;
use function is_array;

/**
 * ButtonGroup renders a button group widget.
 *
 * For example,
 *
 * ```php
 * // a button group with items configuration
 * echo ButtonGroup::widget()
 *     ->buttons([
 *         ['label' => 'A'],
 *         ['label' => 'B'],
 *         ['label' => 'C', 'visible' => false],
 *     ]);
 *
 * // button group with an item as a string
 * echo ButtonGroup::widget()
 *     ->buttons([
 *         SubmitButton::widget()->content('A')->render(),
 *         ['label' => 'B'],
 *     ]);
 * ```
 *
 * Pressing on the button should be handled via JavaScript. See the following for details:
 */
final class ButtonGroup extends ButtonAttributes
{
    private array $buttons = [];
    private bool $container = true;
    private array $containerAttributes = [];
    private string $containerClass = '';
    /** @psalm-var array[] */
    private array $individualButtonAttributes = [];

    /**
     * List of buttons. Each array element represents a single button which can be specified as a string or an array of
     * the following structure:
     *
     * - label: string, required, the button label.
     * - attributes: array, optional, the HTML attributes of the button.
     * - type: string, optional, the button type.
     * - visible: bool, optional, whether this button is visible. Defaults to true.
     *
     * @param array $values The buttons' configuration.
     *
     * @return self
     */
    public function buttons(array $values): self
    {
        $new = clone $this;
        $new->buttons = $values;

        return $new;
    }

    /**
     * Enable, disabled container for field.
     *
     * @param bool $value Is the container disabled or not.
     *
     * @return static
     */
    public function container(bool $value): self
    {
        $new = clone $this;
        $new->container = $value;
        return $new;
    }

    /**
     * Set container attributes.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * ```php
     * ['class' => 'test-class']
     * ```
     *
     * @return static
     *
     * @psalm-param array<string, string> $values
     */
    public function containerAttributes(array $values): self
    {
        $new = clone $this;
        $new->containerAttributes = array_merge($new->containerAttributes, $values);
        return $new;
    }

    /**
     * Set container css class.
     *
     * @return static
     */
    public function containerClass(string $value): self
    {
        $new = clone $this;
        $new->containerClass = $value;
        return $new;
    }

    /**
     * Set the ID of the container field.
     *
     * @param string|null $id
     *
     * @return static
     */
    public function containerId(?string $id): self
    {
        $new = clone $this;
        $new->containerAttributes['id'] = $id;
        return $new;
    }

    /**
     * Set the name of the container field.
     *
     * @param string|null $id
     *
     * @return static
     */
    public function containerName(?string $id): self
    {
        $new = clone $this;
        $new->containerAttributes['name'] = $id;
        return $new;
    }

    /**
     * The specified attributes for button.
     *
     * @param array $values The button attributes.
     *
     * @return static
     *
     * @psalm-param array[] $values
     */
    public function individualButtonAttributes(array $values = []): self
    {
        $new = clone $this;
        $new->individualButtonAttributes = $values;
        return $new;
    }

    protected function run(): string
    {
        $div = Div::tag();

        if ($this->containerClass !== '') {
            $div = $div->class($this->containerClass);
        }

        if ($this->containerAttributes !== []) {
            $div = $div->attributes($this->containerAttributes);
        }

        return $this->container ?
            $div->content(PHP_EOL . $this->renderButtons() . PHP_EOL)->encode(false)->render() : $this->renderButtons();
    }

    /**
     * Generates the buttons that compound the group as specified on {@see buttons}.
     *
     * @return string the rendering result.
     */
    private function renderButtons(): string
    {
        $htmlButtons = [];

        /** @psalm-var array<string, array|string> */
        $buttons = $this->buttons;

        foreach ($buttons as $key => $button) {
            if (is_array($button)) {
                /** @var array */
                $attributes = $button['attributes'] ?? [];
                $attributes = array_merge($attributes, $this->build($this->attributes, '-button'));

                // Set individual button attributes.
                $individualButtonAttributes = $this->individualButtonAttributes[$key] ?? [];
                $attributes = array_merge($attributes, $individualButtonAttributes);

                /** @var string */
                $label = $button['label'] ?? '';

                /** @var string */
                $type = $button['type'] ?? 'button';

                /** @var bool */
                $visible = $button['visible'] ?? true;

                if ($visible === false) {
                    continue;
                }

                $htmlButtons[] = Input::tag()->attributes($attributes)->value($label)->type($type)->render();
            } else {
                $htmlButtons[] = $button;
            }
        }

        return implode("\n", $htmlButtons);
    }
}
