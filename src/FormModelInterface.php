<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Yiisoft\Validator\DataSetInterface;

/**
 * FormModelInterface model represents an HTML form: its data, validation and presentation.
 */
interface FormModelInterface extends DataSetInterface, FormMetadataInterface
{
    /**
     * Return array with names of all attributes
     *
     * @return array
     */
    public function attributes(): array;

    /**
     * Returns the value for the specified attribute.
     *
     * @param string $attribute
     *
     * @return mixed
     */
    public function getAttributeValue(string $attribute): mixed;

    /**
     * If there is such attribute in the set.
     *
     * @param string $attribute
     *
     * @return bool
     */
    public function hasAttribute(string $attribute): bool;

    /**
     * @return FormErrorsInterface Validation errors.
     */
    public function getFormErrors(): FormErrorsInterface;

    /**
     * Returns the form name that this model class should use.
     *
     * The form name is mainly used by {@see \Yiisoft\Form\Helper\HtmlForm} to determine how to name the input
     * fields for the attributes in a model.
     * If the form name is "A" and an attribute name is "b", then the corresponding input name would be "A[b]".
     * If the form name is an empty string, then the input name would be "b".
     *
     * The purpose of the above naming schema is that for forms which contain multiple different models, the attributes
     * of each model are grouped in sub-arrays of the POST-data, and it is easier to differentiate between them.
     *
     * By default, this method returns the model class name (without the namespace part) as the form name. You may
     * override it when the model is used in different forms.
     *
     * @return string the form name of this model class.
     *
     * {@see load()}
     */
    public function getFormName(): string;

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by {@see \Yiisoft\Validator\Validator} to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * Each rule is an array with the following structure:
     *
     * ```php
     * public function getRules(): array
     * {
     *     return [
     *         'login' => $this->loginRules()
     *     ];
     * }
     *
     * private function loginRules(): array
     * {
     *   return [
     *       new \Yiisoft\Validator\Rule\Required(),
     *       new \Yiisoft\Validator\Rule\Length(
     *           min: 4,
     *           max: 40,
     *           lessThanMinMessage: 'Is too short.',
     *           greaterThanMaxMessage: 'Is too long.',
     *       ),
     *       new \Yiisoft\Validator\Rule\Email()
     *   ];
     * }
     * ```
     *
     * @return array Validation rules.
     */
    public function getRules(): array;

    /**
     * This method allows knowing if the validation was executed or not in the model.
     *
     * @return bool If the model was validated.
     */
    public function isValidated(): bool;

    /**
     * Populates the model with input data.
     *
     * which, with `load()` can be written as:
     *
     * ```php
     * $body = $request->getParsedBody();
     * $method = $request->getMethod();
     *
     * if ($method === Method::POST && $loginForm->load($body)) {
     *     // handle success
     * }
     * ```
     *
     * `load()` gets the `'FormName'` from the {@see getFormName()} method (which you may override), unless the
     * `$formName` parameter is given. If the form name is empty string, `load()` populates the model with the whole of
     * `$data` instead of `$data['FormName']`.
     *
     * @param array|object|null $data The data to load, typically server request attributes.
     * @param string|null $formName scope from which to get data
     *
     * @return bool whether `load()` found the expected form in `$data`.
     */
    public function load(array|object|null $data, ?string $formName = null): bool;

    /**
     * Set specified attribute
     *
     * @param string $name of the attribute to set
     * @param mixed $value
     */
    public function setAttribute(string $name, mixed $value): void;

    /**
     * Set custom form errors instance.
     */
    public function setFormErrors(FormErrorsInterface $formErrors): void;
}
