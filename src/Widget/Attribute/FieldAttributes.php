<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Attribute;

abstract class FieldAttributes extends WidgetAttributes
{
    private bool $ariaDescribedBy = false;
    /** @psalm-var array[][] */
    private array $buttonsIndividualAttributes = [];

    private bool $container = true;
    private array $containerAttributes = [];
    private string $containerClass = '';
    private array $containerIndividualClass = [];

    private ?string $error = '';
    private array $errorAttributes = [];
    private string $errorClass = '';
    /** @psalm-var string[] */
    private array $errorIndividualClass = [];
    private array $errorMessageCallback = [];
    private string $errorTag = 'div';

    private ?string $hint = '';
    private array $hintAttributes = [];
    private string $hintClass = '';
    /** @psalm-var string[] */
    protected array $hintIndividualClass = [];
    private string $hintTag = 'div';

    protected string $id = '';
    protected string $inputClass = '';
    protected array $inputsClass = [];

    private ?string $label = '';
    private array $labelAttributes = [];
    private string $labelClass = '';
    /** @psalm-var string[] */
    private array $labelIndividualClass = [];

    protected string $invalidClass = '';
    /** @psalm-var array<string, string> */
    protected array $invalidsClass = [];
    protected string $validClass = '';
    /** @psalm-var array<string, string> */
    protected array $validsClass = [];
    protected string $template = "{label}\n{input}\n{hint}\n{error}";
    /** @psalm-var array<string, string> */
    protected array $templates = [];
    protected array $parts = [];
    protected string $type = '';
    protected ?string $placeholder = null;

    /**
     * Set invalid class each for field type.
     *
     * @param array $invalidClass the input class to be used to layout the field.
     *
     * ```php
     * [Field::TYPE_TEXT => 'test-class-1', Field::TYPE_SUBMIT_BUTTON => 'test-class-2']
     *
     * @return static
     *
     * @psalm-param array<string, string> $invalidClass
     */
    public function addInvalidClass(array $invalidClass): self
    {
        $new = clone $this;
        $new->invalidsClass = $invalidClass;
        return $new;
    }

    /**
     * Set layout template for render a field with label, input, hint and error.
     *
     * @param array $template the template to be used to layout the field.
     *
     * ```php
     * [Field::TYPE_TEXT => '{input}', Field::TYPE_SUBMIT_BUTTON => '<div>{input}</div>']
     *
     * @return static
     *
     * @psalm-param array<string, string> $template
     */
    public function addTemplate(array $template): self
    {
        $new = clone $this;
        $new->templates = $template;
        return $new;
    }

    /**
     * Set invalid class each for field type.
     *
     * @param array $validsClass the input class to be used to layout the field.
     *
     * ```php
     * [Field::TYPE_TEXT => 'test-class-1', Field::TYPE_SUBMIT_BUTTON => 'test-class-2']
     *
     * @return static
     *
     * @psalm-param array<string, string> $validsClass
     */
    public function addValidClass(array $validsClass): self
    {
        $new = clone $this;
        $new->validsClass = $validsClass;
        return $new;
    }

    /**
     * Set aria-describedby attribute.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/WCAG20-TECHS/ARIA1.html
     */
    public function ariaDescribedBy(): self
    {
        $new = clone $this;
        $new->ariaDescribedBy = true;
        return $new;
    }

    /**
     * Set individual attributes for the buttons widgets.
     *
     * @param array $values Attribute values indexed by attribute names.
     * ```php
     * [0 => ['value' => 'Submit'], 1 => ['value' => 'Reseteable']]
     * ```
     *
     * @return static
     *
     * @psalm-param array[][] $values
     */
    public function buttonsIndividualAttributes(array $values): self
    {
        $new = clone $this;
        $new->buttonsIndividualAttributes = $values;
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
     * Set error message for the field.
     *
     * @param string|null $value the error message.
     *
     * @return static The field widget instance.
     */
    public function error(?string $value): self
    {
        $new = clone $this;
        $new->error = $value;
        return $new;
    }

    /**
     * Set error attributes.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * ```php
     * ['class' => 'test-class']
     * ```
     *
     * @return static The field widget instance.
     */
    public function errorAttributes(array $values): self
    {
        $new = clone $this;
        $new->errorAttributes = $values;
        return $new;
    }

    /**
     * Set error css class.
     *
     * @return static
     */
    public function errorClass(string $value): self
    {
        $new = clone $this;
        $new->errorClass = $value;
        return $new;
    }

    /**
     * Set error class used for an invalid field.
     *
     * @param array $errorClass The error class to apply to an invalid field.
     *
     * ```php
     * [Field::TYPE_TEXT => 'test-class-1', Field::TYPE_SUBMIT_BUTTON => 'test-class-2']
     * ```
     *
     * @return static
     *
     * @psalm-param array<string, string> $errorClass
     */
    public function errorIndividualClass(array $errorClass): self
    {
        $new = clone $this;
        $new->errorIndividualClass = $errorClass;
        return $new;
    }

    /**
     * Callback that will be called to obtain an error message.
     *
     * The signature of the callback must be:
     *
     * ```php
     * [$FormModel, function()]
     * ```
     *
     * @param array $value
     *
     * @return static
     */
    public function errorMessageCallback(array $value): self
    {
        $new = clone $this;
        $new->errorMessageCallback = $value;
        return $new;
    }

    /**
     * The tag name of the container element.
     *
     * Empty to render error messages without container {@see Html::tag()}.
     *
     * @param string $value
     *
     * @return static
     */
    public function errorTag(string $value): self
    {
        $new = clone $this;
        $new->errorTag = $value;
        return $new;
    }

    public function getAriaDescribedBy(): bool
    {
        return $this->ariaDescribedBy;
    }

    public function getButtonsIndividualAttributes(string $index): ?array
    {
        return $this->buttonsIndividualAttributes[$index] ?? null;
    }

    public function getContainer(): bool
    {
        return $this->container;
    }

    public function getContainerAttributes(): array
    {
        return $this->containerAttributes;
    }

    public function getContainerClass(): string
    {
        return $this->containerClass;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function getErrorAttributes(): array
    {
        return $this->errorAttributes;
    }

    public function getErrorClass(): string
    {
        return $this->errorClass;
    }

    public function getErrorIndividualClass(string $type): ?string
    {
        return $this->errorIndividualClass[$type] ?? null;
    }

    public function getErrorMessageCallback(): array
    {
        return $this->errorMessageCallback;
    }

    public function getErrorTag(): string
    {
        return $this->errorTag;
    }

    public function getHint(): ?string
    {
        return $this->hint;
    }

    public function getHintAttributes(): array
    {
        return $this->hintAttributes;
    }

    public function getHintClass(): string
    {
        return $this->hintClass;
    }

    public function getHintIndividualClass(string $type): ?string
    {
        return $this->hintIndividualClass[$type] ?? null;
    }

    public function getHintTag(): string
    {
        return $this->hintTag;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getLabelAttributes(): array
    {
        return $this->labelAttributes;
    }

    public function getLabelClass(): string
    {
        return $this->labelClass;
    }

    public function getLabelIndividualClass(string $type): ?string
    {
        return $this->labelIndividualClass[$type] ?? null;
    }

    /**
     * Set hint message for the field.
     *
     * @return static
     */
    public function hint(?string $value): self
    {
        $new = clone $this;
        $new->hint = $value;
        return $new;
    }

    /**
     * Set hint attributes.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * ```php
     * ['class' => 'test-class']
     * ```
     *
     * @return static The field widget instance.
     */
    public function hintAttributes(array $values): self
    {
        $new = clone $this;
        $new->hintAttributes = $values;
        return $new;
    }

    /**
     * Set hint css class.
     *
     * @return static
     */
    public function hintClass(string $value): self
    {
        $new = clone $this;
        $new->hintClass = $value;
        return $new;
    }

    /**
     * Set hint tag name.
     *
     * @return static
     */
    public function hintTag(string $value): self
    {
        $new = clone $this;
        $new->hintTag = $value;
        return $new;
    }

    /**
     * Set hint class for a field.
     *
     * @param array $hintClass The hint class to be applied to a field.
     *
     * ```php
     * [Field::TYPE_TEXT => 'test-class-1', Field::TYPE_SUBMIT_BUTTON => 'test-class-2']
     *
     * @return static
     *
     * @psalm-param array<string, string> $hintClass
     */
    public function hintIndividualClass(array $hintClass): self
    {
        $new = clone $this;
        $new->hintIndividualClass = $hintClass;
        return $new;
    }

    /**
     * Set input css class.
     *
     * @return static
     */
    public function inputClass(string $value): self
    {
        $new = clone $this;
        $new->inputClass = $value;
        return $new;
    }

    /**
     * Set invalid css class.
     *
     * @return static
     */
    public function invalidClass(string $value): self
    {
        $new = clone $this;
        $new->invalidClass = $value;
        return $new;
    }

    /**
     * Set label message for the field.
     *
     * @return static
     */
    public function label(?string $value): self
    {
        $new = clone $this;
        $new->label = $value;
        return $new;
    }

    /**
     * Set label attributes.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * ```php
     * ['class' => 'test-class']
     * ```
     *
     * @return static The field widget instance.
     */
    public function labelAttributes(array $values): self
    {
        $new = clone $this;
        $new->labelAttributes = $values;
        return $new;
    }

    /**
     * Set the label css class.
     *
     * @return static
     */
    public function labelClass(string $value): self
    {
        $new = clone $this;
        $new->labelClass = $value;
        return $new;
    }

    /**
     * The id of a labelable form-related element in the same document as the tag label element.
     *
     * The first element in the document with an id matching the value of the for attribute is the labeled control for
     * this label element, if it is a labelable element.
     *
     * @param string|null $value The id of a labelable form-related element in the same document as the tag label
     * element. If null, the attribute will be removed.
     *
     * @return static
     */
    public function labelFor(?string $value): self
    {
        $new = clone $this;
        $new->labelAttributes['for'] = $value;
        return $new;
    }

    /**
     * It allows defining placeholder.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#the-placeholder-attribute
     */
    public function placeholder(string $value): self
    {
        $new = clone $this;
        $new->placeholder = $value;
        return $new;
    }

    /**
     * A Boolean attribute which, if present, means this field cannot be edited by the user.
     * Its value can, however, still be changed by JavaScript code directly setting the HTMLInputElement.value
     * property.
     *
     * @param bool $value
     *
     * @return static
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#the-readonly-attribute
     */
    public function readonly(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['readonly'] = $value;
        return $new;
    }

    /**
     * If it is required to fill in a value in order to submit the form.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#the-required-attribute
     */
    public function required(): self
    {
        $new = clone $this;
        $new->attributes['required'] = true;
        return $new;
    }

    /**
     * Set layout template for render a field.
     *
     * @param string $value
     *
     * @return static
     */
    public function template(string $value): self
    {
        $new = clone $this;
        $new->template = $value;
        return $new;
    }

    /**
     * Set the value valid css class.
     *
     * @param string $value is the valid css class.
     *
     * @return static
     */
    public function validClass(string $value): self
    {
        $new = clone $this;
        $new->validClass = $value;
        return $new;
    }

    /**
     * Set container class each for field type.
     *
     * @param array $containerClass The container class to be applied to field's container tag.
     *
     * ```php
     * [Field::TYPE_TEXT => 'test-class-1', Field::TYPE_SUBMIT_BUTTON => 'test-class-2']
     *
     * @return static
     *
     * @psalm-param array<string, string> $containerClass
     */
    public function containerIndividualClass(array $containerClass): self
    {
        $new = clone $this;
        $new->containerIndividualClass = $containerClass;
        return $new;
    }

    /**
     * Disabled container for field.
     *
     * @return static
     */
    public function withoutContainer(): self
    {
        $new = clone $this;
        $new->container = false;
        return $new;
    }

    /**
     * Set input class for a field.
     *
     * @param array $inputClass The input class to be applied field container.
     *
     * ```php
     * [Field::TYPE_TEXT => 'test-class-1', Field::TYPE_SUBMIT_BUTTON => 'test-class-2']
     *
     * @return static
     *
     * @psalm-param array<string, string> $inputClass
     */
    public function withInputClass(array $inputClass): self
    {
        $new = clone $this;
        $new->inputsClass = $inputClass;
        return $new;
    }
}
