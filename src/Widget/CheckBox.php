<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget;

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Widget\Widget;

final class CheckBox extends Widget
{
    private ?string $id = null;
    private FormModelInterface $data;
    private string $attribute;
    private array $options = [];
    private string $charset = 'UTF-8';
    private bool $noLabel = false;
    private bool $uncheck = true;

    /**
     * Generates a checkbox tag together with a label for the given form attribute.
     *
     * This method will generate the "checked" tag attribute according to the form attribute value.
     *
     * @return string the generated checkbox tag.
     */
    public function run(): string
    {
        return BooleanInput::widget()
            ->type('checkbox')
            ->id($this->id)
            ->config($this->data, $this->attribute, $this->options)
            ->noLabel($this->noLabel)
            ->uncheck($this->uncheck)
            ->run();
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
     * Set the Id of the widget.
     *
     * @param string $value
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
     * Label displayed next to the checkbox.
     *
     * It will NOT be HTML-encoded, therefore you can pass in HTML code such as an image tag. If this is is coming from
     * end users, you should {@see encode()} it to prevent XSS attacks.
     *
     * When this option is specified, the checkbox will be enclosed by a label tag.
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
     * the HTML attributes for the label tag.
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
     * Allows you to disable the widgets label tag.
     *
     * @param bool $value
     *
     * @return self
     */
    public function noLabel(bool $value = true): self
    {
        $new = clone $this;
        $new->noLabel = $value;
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
     * The value associated with the uncheck state of the checkbox.
     *
     * When this attribute is present, a hidden input will be generated so that if the checkbox is not checked and
     * is submitted, the value of this attribute will still be submitted to the server via the hidden input.
     *
     * @param bool $value
     *
     * @return self
     */
    public function uncheck(bool $value = true): self
    {
        $new = clone $this;
        $new->uncheck = $value;
        return $new;
    }
}
