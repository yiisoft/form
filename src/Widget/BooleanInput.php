<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use InvalidArgumentException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

final class BooleanInput extends Widget
{
    private ?string $id = null;
    private FormModelInterface $data;
    private string $attribute;
    private array $options = [];
    private string $type;
    private string $charset = 'UTF-8';
    private bool $enclosedByLabel = true;
    private bool $uncheck = true;

    /**
     * Generates a boolean input.
     *
     * This method is mainly called by {@see CheckboxForm} and {@see RadioForm}.
     *
     * @return string the generated input element.
     */
    public function run(): string
    {
        $new = clone $this;
        $type = $new->type;

        $tag = Html::$type($new->getName());

        $label = ArrayHelper::remove($new->options, 'label');
        if ($new->enclosedByLabel) {
            $label ??= $new->data->getAttributeLabel(HtmlForm::getAttributeName($new->attribute));
        }
        if ($label !== null) {
            $labelAttributes = ArrayHelper::remove($new->options, 'labelOptions');
            $tag = $tag->label($label, $labelAttributes ?? []);
        }

        unset($new->options['uncheck']);
        if ($new->uncheck) {
            $tag = $tag->uncheckValue('0');
        } else {
            $uncheckValue = null;
        }

        if (!empty($new->getId())) {
            $new->options['id'] = $new->getId();
        }

        return $tag
            ->checked($new->getBooleanValue())
            ->attributes($new->options)
            ->render();
    }

    /**
     * Set form model, name and options for the widget.
     *
     * @param FormModelInterface $data Form model.
     * @param string $attribute Form model property this widget is rendered for.
     * @param array $options The HTML attributes for the widget container tag.
     * See {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @return self
     */
    public function config(FormModelInterface $data, string $attribute, array $options = []): self
    {
        $new = clone $this;
        $new->data = $data;
        $new->attribute = $attribute;
        $new->options = $options;
        return $new;
    }

    /**
     * Focus on the control (put cursor into it) when the page loads.
     * Only one form element could be in focus at the same time.
     *
     * It cannot be applied if the type attribute is "hidden" (that is, you cannot automatically set the cursor
     * to a hidden control).
     *
     * @param bool $value
     *
     * @return self
     */
    public function autofocus(bool $value = true): self
    {
        $new = clone $this;
        $new->options['autofocus'] = $value;
        return $new;
    }

    /**
     * Set the character set used to generate the widget id. See {@see HtmlForm::getInputId()}.
     *
     * @param string $value
     *
     * @return self
     */
    public function charset(string $value): self
    {
        $new = clone $this;
        $new->charset = $value;
        return $new;
    }

    /**
     * Set whether the element is disabled or not.
     *
     * If this attribute is set to `true`, the element is disabled. Disabled elements are usually drawn with grayed-out
     * text.
     * If the element is disabled, it does not respond to user actions, it cannot be focused, and the command event
     * will not fire. In the case of form elements, it will not be submitted. Do not set the attribute to true, as
     * this will suggest you can set it to false to enable the element again, which is not the case.
     *
     * @param bool $value
     *
     * @return self
     */
    public function disabled(bool $value = true): self
    {
        $new = clone $this;
        $new->options['disabled'] = $value;
        return $new;
    }

    /**
     * Specifies the form element the tag input element belongs to. The value of this attribute must be the id
     * attribute of a {@see Form} element in the same document.
     *
     * @param string $value
     *
     * @return self
     */
    public function form(string $value): self
    {
        $new = clone $this;
        $new->options['form'] = $value;
        return $new;
    }

    /**
     * Set the Id of the widget.
     *
     * @param string|null $value
     *
     * @return self
     */
    public function id(?string $value): self
    {
        $new = clone $this;
        $new->id = $value;
        return $new;
    }

    /**
     * Label displayed next to the boolean input.
     *
     * It will NOT be HTML-encoded, therefore you can pass in HTML code such as an image tag. If this is is coming from
     * end users, you should {@see encode()} it to prevent XSS attacks.
     *
     * When this option is specified, the boolean input will be enclosed by a label tag.
     *
     * @param string $value
     *
     * @return self
     */
    public function label(string $value): self
    {
        $new = clone $this;
        $new->options['label'] = $value;
        return $new;
    }

    /**
     * HTML attributes for the label tag.
     *
     * Do not set this option unless you set the "label" option.
     *
     * @param array $value
     *
     * @return self
     */
    public function labelOptions(array $value = []): self
    {
        $new = clone $this;
        $new->options['labelOptions'] = $value;
        return $new;
    }

    /**
     * If the widget should be enclosed by label.
     *
     * @param bool $value
     *
     * @return self
     */
    public function enclosedByLabel(bool $value = true): self
    {
        $new = clone $this;
        $new->enclosedByLabel = $value;
        return $new;
    }

    /**
     * If it is required to fill in a value in order to submit the form.
     *
     * @param bool $value
     *
     * @return self
     */
    public function required(bool $value = true): self
    {
        $new = clone $this;
        $new->options['required'] = $value;
        return $new;
    }

    /**
     * Type of the input control to use.
     *
     * @param string $value
     *
     * @return self
     */
    public function type(string $value): self
    {
        if (!in_array($value, ['checkbox', 'radio'], true)) {
            throw new InvalidArgumentException('Type should be either "checkbox" or "radio".');
        }
        $new = clone $this;
        $new->type = $value;
        return $new;
    }

    /**
     * The value associated with the uncheck state of the boolean input.
     *
     * When this attribute is present, a hidden input will be generated so that if the boolean input is not checked and
     * is submitted, the value of this attribute will still be submitted to the server via the hidden input.
     *
     * @param bool $value
     *
     * @return self
     */
    public function uncheck(bool $value = false): self
    {
        $new = clone $this;
        $new->uncheck = $value;
        return $new;
    }

    private function getId(): string
    {
        $id = $this->options['id'] ?? $this->id;

        if ($id === null) {
            $id = HtmlForm::getInputId($this->data, $this->attribute, $this->charset);
        }

        return $id !== false ? (string) $id : '';
    }

    private function getName(): string
    {
        return ArrayHelper::remove($this->options, 'name', HtmlForm::getInputName($this->data, $this->attribute));
    }

    private function getBooleanValue(): bool
    {
        $value = HtmlForm::getAttributeValue($this->data, $this->attribute);

        if (!array_key_exists('value', $this->options)) {
            $this->options['value'] = '1';
        }

        return (bool) $value;
    }
}
