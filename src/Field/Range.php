<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Form\Field\Base\AbstractInputField;
use Yiisoft\Html\Html;

use function is_string;

/**
 * An imprecise control for setting the element’s value to a string representing a number.
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#range-state-(type=range)
 */
final class Range extends AbstractInputField
{
    private bool $showOutput = false;

    /**
     * @psalm-var non-empty-string
     */
    private string $outputTagName = 'span';
    private array $outputTagAttributes = [];

    /**
     * Maximum value.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-max
     */
    public function max(float|int|string|Stringable|null $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['max'] = $value;
        return $new;
    }

    /**
     * Minimum value.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-min
     */
    public function min(float|int|string|Stringable|null $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['min'] = $value;
        return $new;
    }

    /**
     * Granularity to be matched by the form control's value.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-step
     */
    public function step(float|int|string|Stringable|null $value): self
    {
        $new = clone $this;
        $new->inputTagAttributes['step'] = $value;
        return $new;
    }

    /**
     * ID of element that lists predefined options suggested to the user.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#the-list-attribute
     */
    public function list(?string $id): self
    {
        $new = clone $this;
        $new->inputTagAttributes['list'] = $id;
        return $new;
    }

    public function showOutput(bool $show = true): self
    {
        $new = clone $this;
        $new->showOutput = $show;
        return $new;
    }

    public function outputTagName(string $tagName): self
    {
        if ($tagName === '') {
            throw new InvalidArgumentException('The output tag name it cannot be empty value.');
        }

        $new = clone $this;
        $new->outputTagName = $tagName;
        return $new;
    }

    public function outputTagAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->outputTagAttributes = $attributes;
        return $new;
    }

    protected function generateInput(): string
    {
        $value = $this->getAttributeValue();

        if (!is_string($value) && !is_numeric($value) && $value !== null) {
            throw new InvalidArgumentException('Range widget requires a string, numeric or null value.');
        }

        $tag = Html::range($this->getInputName(), $value, $this->getInputTagAttributes());
        if ($this->showOutput) {
            $tag = $tag
                ->showOutput()
                ->outputTagName($this->outputTagName)
                ->outputTagAttributes($this->outputTagAttributes);
        }

        return $tag->render();
    }
}
