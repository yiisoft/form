<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;

final class TextArea extends Widget
{
    private ?string $id = null;
    private FormModelInterface $data;
    private string $attribute;
    private array $options = [];
    private string $charset = 'UTF-8';
    private bool $noPlaceholder = false;

    /**
     * Generates a textarea tag for the given form attribute.
     *
     * @return string the generated textarea tag.
     */
    public function run(): string
    {
        $new = clone $this;

        if ($new->noPlaceholder === false) {
            $new->setPlaceholder();
        }

        if (!empty($new->getId())) {
            $new->options['id'] = $new->getId();
        }

        return Html::textarea($new->getName(), $new->getValue(), $new->options);
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
     * The minimum number of characters (as UTF-16 code units) the user can enter into the text input.
     *
     * This must be an non-negative integer value smaller than or equal to the value specified by maxlength.
     * If no minlength is specified, or an invalid value is specified, the text input has no minimum length.
     *
     * @param int $value
     *
     * @return self
     */
    public function minlength(int $value): self
    {
        $new = clone $this;
        $new->options['minlength'] = $value;
        return $new;
    }

    /**
     * The maxlength attribute defines the maximum number of characters (as UTF-16 code units) the user can enter into
     * an tag input.
     *
     * If no maxlength is specified, or an invalid value is specified, the tag input has no maximum length.
     *
     * @param int $value
     *
     * @return self
     */
    public function maxlength(int $value): self
    {
        $new = clone $this;
        $new->options['maxlength'] = $value;
        return $new;
    }

    /**
     * Allows you to disable placeholder.
     *
     * @param bool $value
     *
     * @return self
     */
    public function noPlaceholder(bool $value = true): self
    {
        $new = clone $this;
        $new->noPlaceholder = $value;
        return $new;
    }

    /**
     * It allows defining placeholder.
     *
     * @param string $value
     *
     * @return self
     */
    public function placeholder(string $value): self
    {
        $new = clone $this;
        $new->options['placeholder'] = $value;
        return $new;
    }

    /**
     * A Boolean attribute which, if present, means this field cannot be edited by the user.
     * Its value can, however, still be changed by JavaScript code directly setting the HTMLInputElement.value
     * property.
     *
     * @param bool $value
     *
     * @return self
     */
    public function readOnly(bool $value = true): self
    {
        $new = clone $this;
        $new->options['readonly'] = $value;
        return $new;
    }

    /**
     * Spellcheck is a global attribute which is used to indicate whether or not to enable spell checking for an
     * element.
     *
     * @param bool $value
     *
     * @return self
     */
    public function spellcheck(bool $value = true): self
    {
        $new = clone $this;
        $new->options['spellcheck'] = $value;
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
     * The tabindex global attribute indicates that its element can be focused, and where it participates in sequential
     * keyboard navigation (usually with the Tab key, hence the name).
     *
     * It accepts an integer as a value, with different results depending on the integer's value:
     *
     * - A negative value (usually tabindex="-1") means that the element is not reachable via sequential keyboard
     * navigation, but could be focused with Javascript or visually. It's mostly useful to create accessible widgets
     * with JavaScript.
     * - tabindex="0" means that the element should be focusable in sequential keyboard navigation, but its order is
     * defined by the document's source order.
     * - A positive value means the element should be focusable in sequential keyboard navigation, with its order
     * defined by the value of the number. That is, tabindex="4" is focused before tabindex="5", but after tabindex="3".
     *
     * @param int $value
     *
     * @return self
     */
    public function tabIndex(int $value = 0): self
    {
        $new = clone $this;
        $new->options['tabindex'] = $value;
        return $new;
    }

    /**
     * The title global attribute contains text representing advisory information related to the element it belongs to.
     *
     * @param string $value
     *
     * @return self
     */
    public function title(string $value): self
    {
        $new = clone $this;
        $new->options['title'] = $value;
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

    private function getValue()
    {
        $value = HtmlForm::getAttributeValue($this->data, $this->attribute);
        if ($value !== null && is_scalar($value)) {
            $value = (string)$value;
        }

        return ArrayHelper::remove(
            $this->options,
            'value',
            $value
        );
    }

    private function setPlaceholder(): void
    {
        if (!isset($this->options['placeholder'])) {
            $attributeName = Html::getAttributeName($this->attribute);
            $this->options['placeholder'] = $this->data->attributeLabel($attributeName);
        }
    }
}
