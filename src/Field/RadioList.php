<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Closure;
use InvalidArgumentException;
use LogicException;
use Stringable;
use Yiisoft\Form\Field\Base\InputData\InputDataWithCustomNameAndValueTrait;
use Yiisoft\Form\Field\Base\PartsField;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassInterface;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassTrait;
use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Field\Part\Label;
use Yiisoft\Html\Widget\RadioList\RadioItem;
use Yiisoft\Html\Widget\RadioList\RadioList as RadioListWidget;

use function is_bool;
use function is_string;

/**
 * @see RadioListWidget
 */
final class RadioList extends PartsField implements ValidationClassInterface
{
    use InputDataWithCustomNameAndValueTrait;
    use ValidationClassTrait;

    private RadioListWidget $widget;
    private array $radioAttributes = [];

    public function __construct()
    {
        $this->widget = RadioListWidget::create('');
    }

    public function radioWrapTag(?string $name): self
    {
        $new = clone $this;
        $new->widget = $this->widget->radioWrapTag($name);
        return $new;
    }

    public function radioWrapAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->widget = $this->widget->radioWrapAttributes($attributes);
        return $new;
    }

    public function radioWrapClass(?string ...$class): self
    {
        $new = clone $this;
        $new->widget = $this->widget->radioWrapClass(...$class);
        return $new;
    }

    public function addRadioWrapClass(?string ...$class): self
    {
        $new = clone $this;
        $new->widget = $this->widget->addRadioWrapClass(...$class);
        return $new;
    }

    public function radioAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->radioAttributes = $attributes;
        return $new;
    }

    public function addRadioAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->radioAttributes = array_merge($new->radioAttributes, $attributes);
        return $new;
    }

    public function radioLabelAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->widget = $this->widget->radioLabelAttributes($attributes);
        return $new;
    }

    public function addRadioLabelAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->widget = $this->widget->addRadioLabelAttributes($attributes);
        return $new;
    }

    public function radioLabelWrap(bool $wrap): self
    {
        $new = clone $this;
        $new->widget = $this->widget->radioLabelWrap($wrap);
        return $new;
    }

    /**
     * @param array[] $attributes
     */
    public function individualInputAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->widget = $this->widget->individualInputAttributes($attributes);
        return $new;
    }

    /**
     * @param array[] $attributes
     */
    public function addIndividualInputAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->widget = $this->widget->addIndividualInputAttributes($attributes);
        return $new;
    }

    /**
     * @param string[] $items
     * @param bool $encodeLabels Whether labels should be encoded.
     */
    public function items(array $items, bool $encodeLabels = true): self
    {
        $new = clone $this;
        $new->widget = $this->widget->items($items, $encodeLabels);
        return $new;
    }

    /**
     * Fills items from an array provided. Array values are used for both input labels and input values.
     *
     * @param bool[]|float[]|int[]|string[]|Stringable[] $values
     * @param bool $encodeLabels Whether labels should be encoded.
     */
    public function itemsFromValues(array $values, bool $encodeLabels = true): self
    {
        $new = clone $this;
        $new->widget = $this->widget->itemsFromValues($values, $encodeLabels);
        return $new;
    }

    /**
     * Specifies the form element the tag input element belongs to. The value of this attribute must be the ID
     * attribute of a form element in the same document.
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fae-form
     */
    public function form(?string $formId): self
    {
        $new = clone $this;
        $new->widget = $this->widget->form($formId);
        return $new;
    }

    /**
     * @param bool $disabled Whether radio buttons is disabled.
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-disabled
     */
    public function disabled(bool $disabled = true): self
    {
        $new = clone $this;
        $new->widget = $this->widget->disabled($disabled);
        return $new;
    }

    public function uncheckValue(bool|float|int|string|Stringable|null $value): self
    {
        $new = clone $this;
        $new->widget = $this->widget->uncheckValue($value);
        return $new;
    }

    public function separator(string $separator): self
    {
        $new = clone $this;
        $new->widget = $this->widget->separator($separator);
        return $new;
    }

    /**
     * @psalm-param Closure(RadioItem):string|null $formatter
     */
    public function itemFormatter(?Closure $formatter): self
    {
        $new = clone $this;
        $new->widget = $this->widget->itemFormatter($formatter);
        return $new;
    }

    protected function generateInput(): string
    {
        $name = $this->getName();
        if (empty($name)) {
            throw new LogicException('"RadioList" field requires non-empty name.');
        }

        $value = $this->getValue();
        if (
            !is_bool($value)
            && !is_string($value)
            && !$value instanceof Stringable
            && !is_numeric($value)
            && $value !== null
        ) {
            throw new InvalidArgumentException(
                '"RadioList" field requires a string, Stringable, numeric, bool or null value.',
            );
        }
        /** @psalm-var Stringable|scalar $value */

        $radioAttributes = $this->radioAttributes;
        $this->addInputValidationClassToAttributes(
            $radioAttributes,
            $this->getInputData(),
            $this->hasCustomError() ? true : null,
        );

        return $this->widget
            ->name($name)
            ->value($value)
            ->addRadioAttributes($radioAttributes)
            ->render();
    }

    protected function renderLabel(Label $label): string
    {
        return $label
            ->inputData($this->getInputData())
            ->useInputId(false)
            ->render();
    }

    protected function renderHint(Hint $hint): string
    {
        return $hint
            ->inputData($this->getInputData())
            ->render();
    }

    protected function renderError(Error $error): string
    {
        return $error
            ->inputData($this->getInputData())
            ->render();
    }

    protected function prepareContainerAttributes(array &$attributes): void
    {
        $this->addValidationClassToAttributes(
            $attributes,
            $this->getInputData(),
            $this->hasCustomError() ? true : null,
        );
    }
}
