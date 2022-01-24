<?php

declare(strict_types=1);

namespace Yiisoft\Form\Widget\Attribute;

abstract class FieldAttributes extends WidgetAttributes
{
    private ?bool $ariaDescribedBy = null;
    private ?bool $container = null;
    private array $containerAttributes = [];
    private string $containerClass = '';
    private array $defaultTokens = [];
    private array $defaultValues = [];
    private ?string $error = '';
    private array $errorAttributes = [];
    private string $errorClass = '';
    private array $errorMessageCallback = [];
    private string $errorTag = '';
    private ?string $hint = '';
    private array $hintAttributes = [];
    private string $hintClass = '';
    private string $hintTag = '';
    private string $inputClass = '';
    private ?string $label = '';
    private array $labelAttributes = [];
    private string $labelClass = '';
    private string $invalidClass = '';
    private string $validClass = '';
    private ?string $placeholder = null;
    private string $template = '';
    private string $type = '';

    /**
     * Set aria-describedby attribute.
     *
     * @param bool $value Whether to set aria-describedby attribute.
     *
     * @return static
     *
     * @link https://www.w3.org/TR/WCAG20-TECHS/ARIA1.html
     */
    public function ariaDescribedBy(bool $value): self
    {
        $new = clone $this;
        $new->ariaDescribedBy = $value;
        return $new;
    }

    /**
     * Set aria-label attribute.
     *
     * @param string $value
     *
     * @return static
     */
    public function ariaLabel(string $value): self
    {
        $new = clone $this;
        $new->attributes['aria-label'] = $value;
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
     * Set default tokens.
     *
     * @param array $values Token values indexed by token names.
     *
     * @return static
     */
    public function defaultTokens(array $values): self
    {
        $new = clone $this;
        $new->defaultTokens = $values;
        return $new;
    }

    /**
     * Set default values for field widget.
     *
     * @param array $values The default values indexed by field type.
     *
     * ```php
     * [
     *     Text::class => [
     *         'label' => 'label-test',
     *     ],
     * ];
     *
     * @return static
     */
    public function defaultValues(array $values): self
    {
        $new = clone $this;
        $new->defaultValues = $values;
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
     * The id of a label-able form-related element in the same document as the tag label element.
     *
     * The first element in the document with an id matching the value of the for attribute is the labeled control for
     * this label element, if it is a label-able element.
     *
     * @param string|null $value The id of a label-able form-related element in the same document as the tag label
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
     * Return aria described by field.
     *
     * if aria described by is not set, and aria described by default is set, then return aria described by default.
     *
     * @return bool|null
     */
    protected function getAriaDescribedBy(): ?bool
    {
        $ariaDescribedBy = $this->ariaDescribedBy;
        $ariaDescribedByDefault = $this->getDefaultValue($this->type, 'ariaDescribedBy');

        if (is_bool($ariaDescribedByDefault)) {
            $ariaDescribedBy = $ariaDescribedByDefault;
        }

        return $ariaDescribedBy;
    }

    /**
     * Return attributes for field.
     *
     * if attributes is empty string, and attributes default value is not empty string, then return attributes default
     * value.
     *
     * @return array
     */
    protected function getAttributes(): array
    {
        $attributes = $this->attributes;
        $attributesDefault = $this->getDefaultValue($this->type, 'attributes');

        if (is_array($attributesDefault) && $attributesDefault !== []) {
            $attributes = $attributesDefault;
        }

        return $attributes;
    }

    /**
     * Return attributes button for the field.
     *
     * if attributes button is empty string, and attributes button default value is not empty string, then return
     * attributes default value.
     *
     * @param string $index The index of the attributes button.
     *
     * @return array
     */
    protected function getButtonsAttributes(string $index): array
    {
        $buttonAttributes = $this->attributes;
        $defaultButtonAttributes = $this->getDefaultValue($index, 'attributes');

        if (is_array($defaultButtonAttributes) && $defaultButtonAttributes !== []) {
            $buttonAttributes = $defaultButtonAttributes;
        }

        return $buttonAttributes;
    }

    /**
     * Return enabled, disabled container for field.
     *
     * if container is not set, and container default value is bool, then return container default value.
     *
     * @return bool
     */
    protected function getContainer(): ?bool
    {
        $container = $this->container;
        $containerDefault = $this->getDefaultValue($this->type, 'container');

        if (is_bool($containerDefault)) {
            $container = $containerDefault;
        }

        return $container ?? true;
    }

    /**
     * Return attributes for container for field.
     *
     * if attributes container is empty array, and attributes container default value is not empty array, then return
     * attributes container default value.
     *
     * @return array
     */
    protected function getContainerAttributes(): array
    {
        $containerAttributes = $this->containerAttributes;
        $containerDefaultAttributes = $this->getDefaultValue($this->type, 'containerAttributes');

        if ((is_array($containerDefaultAttributes) && $containerDefaultAttributes !== [])) {
            $containerAttributes = $containerDefaultAttributes;
        }

        return $containerAttributes;
    }

    /**
     * Return class for container field.
     *
     * if container class is empty string, and container class default value is not empty string, then return container
     * class default value.
     *
     * @return string
     */
    protected function getContainerClass(): string
    {
        $containerClass = $this->containerClass;
        $containerDefaultClass = $this->getDefaultValue($this->type, 'containerClass');

        if ((is_string($containerDefaultClass) && $containerDefaultClass !== '')) {
            $containerClass = $containerDefaultClass;
        }

        return $containerClass;
    }

    /**
     * Return default tokens for field.
     *
     * if default tokens is empty array, and default tokens default value is not empty array, then return default tokens
     * default value.
     */
    protected function getDefaultTokens(): array
    {
        $defaultTokens = $this->defaultTokens;
        $defaultTokensDefault = $this->getDefaultValue($this->type, 'defaultTokens');

        if (is_array($defaultTokensDefault) && $defaultTokensDefault !== []) {
            $defaultTokens = $defaultTokensDefault;
        }

        return $defaultTokens;
    }

    /**
     * Return definition for field.
     */
    public function getDefinitions(): array
    {
        $definitions = $this->getDefaultValue($this->type, 'definitions') ?? [];
        return  is_array($definitions) ? $definitions : [];
    }

    /**
     * Return error message for the field.
     *
     * if error message is empty string, and error message default value is not empty string, then return error message
     * default value.
     *
     * @return string
     */
    protected function getError(): ?string
    {
        $error = $this->error;
        $errorDefault = $this->getDefaultValue($this->type, 'error');

        if (is_string($errorDefault) && $errorDefault !== '') {
            $error = $errorDefault;
        }

        return $error;
    }

    /**
     * Return error attribute for the field.
     *
     * if error attribute is empty string, and error attribute default value is not empty string, then return error
     * attribute default value.
     *
     * @return array
     */
    protected function getErrorAttributes(): array
    {
        $errorAttributes = $this->errorAttributes;
        $errorAttributesDefault = $this->getDefaultValue($this->type, 'errorAttributes');

        if (is_array($errorAttributesDefault) && $errorAttributesDefault !== []) {
            $errorAttributes = $errorAttributesDefault;
        }

        return $errorAttributes;
    }

    /**
     * Return error class for the field.
     *
     * if error class is empty string, and error class default value is not empty string, then return error class
     * default value.
     *
     * @return string
     */
    protected function getErrorClass(): string
    {
        $errorClass = $this->errorClass;
        $errorClassDefault = $this->getDefaultValue($this->type, 'errorClass');

        if (is_string($errorClassDefault) && $errorClassDefault !== '') {
            $errorClass = $errorClassDefault;
        }

        return $errorClass;
    }

    /**
     * Return error message callback for the field.
     *
     * if error message callback is empty array, and error message callback default value is not empty array, then
     * return error message callback default value.
     */
    protected function getErrorMessageCallback(): array
    {
        $errorMessageCallback = $this->errorMessageCallback;
        $errorMessageCallbackDefault = $this->getDefaultValue($this->type, 'errorMessageCallback');

        if (is_array($errorMessageCallbackDefault) && $errorMessageCallbackDefault !== []) {
            $errorMessageCallback = $errorMessageCallbackDefault;
        }

        return $errorMessageCallback;
    }

    /**
     * Return error tag for the field.
     *
     * if error tag is empty string, and error tag default value is not empty string, then return error tag default
     * value.
     *
     * @return string
     */
    protected function getErrorTag(): string
    {
        $errorTag = $this->errorTag;
        $errorTagDefault = $this->getDefaultValue($this->type, 'errorTag');

        if (is_string($errorTagDefault) && $errorTagDefault !== '') {
            $errorTag = $errorTagDefault;
        }

        return $errorTag === '' ? 'div' : $errorTag;
    }

    /**
     * Return hint for field.
     *
     * if hint is empty string, and hint default value is not empty string, then return hint default value.
     *
     * @return string
     */
    protected function getHint(): ?string
    {
        $hint = $this->hint;
        $hintDefault = $this->getDefaultValue($this->type, 'hint') ?? '';

        if (is_string($hintDefault) && $hintDefault !== '') {
            $hint = $hintDefault;
        }

        return $hint;
    }

    /**
     * Return hint attributes for field.
     *
     * if hint attributes is empty array, and hint default value is not empty array, then return hint default value.
     *
     * @return array
     */
    protected function getHintAttributes(): array
    {
        $hintAttributes = $this->hintAttributes;
        $hintAttributesDefault = $this->getDefaultValue($this->type, 'hintAttributes') ?? [];

        if (is_array($hintAttributesDefault) && $hintAttributesDefault !== []) {
            $hintAttributes = $hintAttributesDefault;
        }

        return $hintAttributes;
    }

    /**
     * Return hint class for field.
     *
     * if hint class is empty string, and hint default value is not empty string, then return hint default value.
     *
     * @return string
     */
    protected function getHintClass(): string
    {
        $hintClass = $this->hintClass;
        $hintClassDefault = $this->getDefaultValue($this->type, 'hintClass') ?? '';

        if (is_string($hintClassDefault) && $hintClassDefault !== '') {
            $hintClass = $hintClassDefault;
        }

        return $hintClass;
    }

    /**
     * Return hint tag for field.
     *
     * if hint tag is empty string, and hint default value is not empty string, then return hint default value.
     *
     * @return string
     */
    protected function getHintTag(): string
    {
        $hintTag = $this->hintTag;
        $hintTagDefault = $this->getDefaultValue($this->type, 'hintTag') ?? '';

        if (is_string($hintTagDefault) && $hintTagDefault !== '') {
            $hintTag = $hintTagDefault;
        }

        return $hintTag === '' ? 'div' : $hintTag;
    }

    /**
     * Return input class for field.
     *
     * if input class is empty string, and input class default value is not empty string, then return input class
     * default value.
     *
     * @return string
     */
    protected function getInputClass(): string
    {
        $inputClass = $this->inputClass;
        $inputClassDefault = $this->getDefaultValue($this->type, 'inputClass');

        if (is_string($inputClassDefault) && $inputClassDefault !== '') {
            $inputClass = $inputClassDefault;
        }

        return $inputClass;
    }

    /**
     * Return invalid class for field.
     *
     * if invalid class is empty string, and invalid class default value is not empty string, then return invalid class
     * default value.
     *
     * @return string
     */
    protected function getInvalidClass(): string
    {
        $invalidClass = $this->invalidClass;
        $invalidClassDefault = $this->getDefaultValue($this->type, 'invalidClass');

        if (is_string($invalidClassDefault) && $invalidClassDefault !== '') {
            $invalidClass = $invalidClassDefault;
        }

        return $invalidClass;
    }

    /**
     * Return label for field.
     *
     * if label is empty string, and label default value is not empty string, then return label default value.
     *
     * @return string|null
     */
    protected function getLabel(): ?string
    {
        $label = $this->label;
        $labelDefault = $this->getDefaultValue($this->type, 'label') ?? '';

        if (is_string($labelDefault) && $labelDefault !== '') {
            $label = $labelDefault;
        }

        return $label;
    }

    /**
     * Return label attributes for field.
     *
     * if label attributes is empty array, and label attributes default value is not empty array, then return label
     * attributes default value.
     *
     * @return array
     */
    protected function getLabelAttributes(): array
    {
        $labelAttributes = $this->labelAttributes;
        $labelAttributesDefault = $this->getDefaultValue($this->type, 'labelAttributes') ?? [];

        if (is_array($labelAttributesDefault) && $labelAttributesDefault !== []) {
            $labelAttributes = $labelAttributesDefault;
        }

        return $labelAttributes;
    }

    /**
     * Return label css class for field.
     *
     * if label css class is empty string, and label css class default value is not null, then return label css class
     * default value.
     *
     * @return string
     */
    protected function getLabelClass(): string
    {
        $labelClass = $this->labelClass;
        $labelClassDefault = $this->getDefaultValue($this->type, 'labelClass') ?? '';

        if (is_string($labelClassDefault) && $labelClassDefault !== '') {
            $labelClass = $labelClassDefault;
        }

        return $labelClass;
    }

    /**
     * Return placeholder for field.
     *
     * if placeholder is empty string, and placeholder default value is not empty string, then return placeholder
     * default value.
     *
     * @return string
     */
    protected function getPlaceholder(): ?string
    {
        $placeholder = $this->placeholder;
        $placeholderDefault = $this->getDefaultValue($this->type, 'placeholder') ?? '';

        if (is_string($placeholderDefault) && $placeholderDefault !== '') {
            $placeholder = $placeholderDefault;
        }

        return $placeholder;
    }

    /**
     * Return template for field.
     *
     * if template is empty string, and template default value is not empty string, then return template default value.
     *
     * @return string
     */
    protected function getTemplate(): string
    {
        $template = $this->template;
        $templateDefault = $this->getDefaultValue($this->type, 'template') ?? '';

        if (is_string($templateDefault) && $templateDefault !== '') {
            $template = $templateDefault;
        }

        return $template === '' ? "{label}\n{input}\n{hint}\n{error}" : $template;
    }

    /**
     * Return valid class for field.
     *
     * if valid class is empty string, and valid class default value is not empty string, then return valid class
     * default value.
     *
     * @return string
     */
    protected function getValidClass(): string
    {
        $validClass = $this->validClass;
        $validDefaultClass = $this->getDefaultValue($this->type, 'validClass') ?? '';

        if (is_string($validDefaultClass) && $validDefaultClass !== '') {
            $validClass = $validDefaultClass;
        }

        return $validClass;
    }

    /**
     * Set type class of the field.
     *
     * @param string $type The type class of the field.
     *
     * @return static
     */
    protected function type(string $type): self
    {
        $new = clone $this;
        $new->type = $type;
        return $new;
    }

    /**
     * @return array|bool|string|null
     */
    private function getDefaultValue(string $type, string $key)
    {
        /** @var array|string|null */
        return $this->defaultValues[$type][$key] ?? null;
    }
}
