<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Html\Html;
use Yiisoft\Widget\Widget;

use function in_array;

final class Input extends Widget
{
    private ?string $id = null;
    private FormModelInterface $data;
    private string $attribute;
    private array $options = [];
    private string $charset = 'UTF-8';
    private bool $noPlaceholder = false;
    private string $type;

    /**
     * Generates an input tag for the given form attribute.
     *
     * @return string the generated input tag.
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

        return Html::input($new->type, $new->getName(), $new->getValue(), $new->options);
    }

    /**
     * Configure the FormModel options for the widget.
     *
     * @param FormModelInterface $data Represents the {@see FormModel}.
     * @param string $attribute It is the property defined in the {@see FormModel}.
     * @param array $options The HTML attributes for the widget container tag. The following special options are
     * recognized. {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
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
     * This attribute allows you to specify that a form control have the cursor when the page loads, unless the user
     * replaces it, for example, by typing in a different control. Only one form element in the same document can have
     * the autofocus attribute, which is Boolean.
     *
     * It cannot be applied if the type attribute has a hidden value (that is, you cannot automatically set the cursor
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
     * It allows defining the character set used to generate the widget id. {@see HtmlForm::getInputId()}
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
     * Indicates whether the element is disabled or not.
     *
     * If this attribute is set, the element is disabled. Disabled elements are usually drawn with grayed-out text.
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
     * The Boolean required attribute which, if present, indicates that the user must specify a value for the input
     * before the owning form can be submitted.
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
     * Lets you specify the input control to generate.
     *
     * @param string $value
     *
     * @return self
     */
    public function type(string $value): self
    {
        $new = clone $this;
        $new->type = $value;
        return $new;
    }

    private function getId(): string
    {
        $id = $this->options['id'] ?? $this->id;

        if ($id === null) {
            $id = HtmlForm::getInputId($this->data, $this->attribute, $this->charset);
        }

        return $id !== false ? $id : '';
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
        if (!isset($this->options['placeholder']) && !(in_array($this->type, ['date', 'file', 'hidden', 'color']))) {
            $attributeName = Html::getAttributeName($this->attribute);
            $this->options['placeholder'] = $this->data->attributeLabel($attributeName);
        }
    }
}
