<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use InvalidArgumentException;
use Yiisoft\Form\Field\Base\BaseField;
use Yiisoft\Form\Field\Base\InputData\InputDataWithCustomNameAndValueTrait;
use Yiisoft\Html\Html;

use function is_string;

/**
 * Represents `<input>` element of type "hidden" are let web developers include data that cannot be seen or modified by
 * users when a form is submitted
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#hidden-state-(type=hidden)
 * @link https://developer.mozilla.org/docs/Web/HTML/Element/input/hidden
 */
final class Hidden extends BaseField
{
    use InputDataWithCustomNameAndValueTrait;

    protected bool $useContainer = false;

    private ?string $inputId = null;
    private bool $shouldSetInputId = true;
    private array $inputAttributes = [];

    public function inputId(?string $inputId): self
    {
        $new = clone $this;
        $new->inputId = $inputId;
        return $new;
    }

    public function shouldSetInputId(bool $value): self
    {
        $new = clone $this;
        $new->shouldSetInputId = $value;
        return $new;
    }

    public function inputAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->inputAttributes = $attributes;
        return $new;
    }

    public function addInputAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->inputAttributes = array_merge($new->inputAttributes, $attributes);
        return $new;
    }

    /**
     * Replace input tag CSS classes with a new set of classes.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    public function inputClass(?string ...$class): self
    {
        $new = clone $this;
        $new->inputAttributes['class'] = $class;
        return $new;
    }

    /**
     * Add one or more CSS classes to the input tag.
     *
     * @param string|null ...$class One or many CSS classes.
     */
    public function addInputClass(?string ...$class): self
    {
        $new = clone $this;
        Html::addCssClass($new->inputAttributes, $class);
        return $new;
    }

    public function form(?string $value): self
    {
        $new = clone $this;
        $new->inputAttributes['form'] = $value;
        return $new;
    }

    protected function generateContent(): ?string
    {
        $value = $this->getValue();

        if (!is_string($value) && !is_numeric($value) && $value !== null) {
            throw new InvalidArgumentException('Hidden widget requires a string, numeric or null value.');
        }

        $attributes = $this->inputAttributes;
        $this->prepareIdInInputAttributes($attributes);

        return Html::hiddenInput(
            $this->getName(),
            $value,
            $attributes,
        )->render();
    }

    private function prepareIdInInputAttributes(array &$attributes): void
    {
        if ($this->shouldSetInputId) {
            if ($this->inputId !== null) {
                $attributes['id'] = $this->inputId;
            } elseif (!isset($attributes['id'])) {
                $attributes['id'] = $this->getInputData()->getId();
            }
        }
    }
}
