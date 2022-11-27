<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field;

use Closure;
use InvalidArgumentException;
use Stringable;
use Yiisoft\Form\Field\Base\PartsField;
use Yiisoft\Form\Field\Base\FormAttributeTrait;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassInterface;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassTrait;
use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Field\Part\Hint;
use Yiisoft\Form\Field\Part\Label;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Html\Widget\RadioList\RadioItem;
use Yiisoft\Html\Widget\RadioList\RadioList as RadioListWidget;

/**
 * @see RadioListWidget
 */
final class RadioList extends PartsField implements ValidationClassInterface
{
    use FormAttributeTrait;
    use ValidationClassTrait;

    private RadioListWidget $widget;

    public function __construct()
    {
        $this->widget = RadioListWidget::create('');
    }

    public function radioAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->widget = $this->widget->radioAttributes($attributes);
        return $new;
    }

    public function addRadioAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->widget = $this->widget->addRadioAttributes($attributes);
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
     * @param Closure|null $formatter
     *
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
        $value = $this->getFormAttributeValue();

        if (!is_bool($value)
            && !is_string($value)
            && !is_numeric($value)
            && $value !== null
            && (!is_object($value) || !method_exists($value, '__toString'))
        ) {
            throw new InvalidArgumentException(
                '"RadioList" field requires a string, numeric, bool, Stringable or null value.'
            );
        }
        /** @psalm-var Stringable|scalar $value */

        return $this->widget
            ->name($this->getInputName())
            ->value($value)
            ->render();
    }

    protected function renderLabel(Label $label): string
    {
        return $label
            ->formAttribute($this->getFormModel(), $this->formAttribute)
            ->useInputId(false)
            ->render();
    }

    protected function renderHint(Hint $hint): string
    {
        return $hint
            ->formAttribute($this->getFormModel(), $this->formAttribute)
            ->render();
    }

    protected function renderError(Error $error): string
    {
        return $error
            ->formAttribute($this->getFormModel(), $this->formAttribute)
            ->render();
    }

    protected function prepareContainerAttributes(array &$attributes): void
    {
        if ($this->hasFormModelAndAttribute()) {
            $this->addValidationClassToAttributes(
                $attributes,
                $this->getFormModel(),
                $this->getFormAttributeName(),
            );
        }
    }

    private function getInputName(): string
    {
        return HtmlForm::getInputName($this->getFormModel(), $this->formAttribute);
    }
}
