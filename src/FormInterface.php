<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Yiisoft\Validator\DataSetInterface;

interface FormInterface extends DataSetInterface
{
    /**
     * Adds a list of errors.
     *
     * @param array $items a list of errors. The array keys must be attribute names.
     * The array values should be error messages. If an attribute has multiple errors, these errors must be given in
     * terms of an array.
     *
     * You may use the result of {@see errors()} as the value for this parameter.
     */
    public function addErrors(array $items): void;

    /**
     * Adds a new error to the specified attribute.
     *
     * @param string $attribute attribute name
     * @param string $error new error message
     */
    public function addError(string $attribute, string $error): void;

    /**
     * Removes errors for all attributes or a single attribute.
     *
     * @param string|null $attribute attribute name. Use null to remove errors for all attributes.
     */
    public function clearErrors(?string $attribute = null): void;

    /**
     * Returns the attribute labels.
     *
     * Attribute labels are mainly used for display purpose. For example, given an attribute `firstName`, we can
     * declare a label `First Name` which is more user-friendly and can be displayed to end users.
     *
     * By default an attribute label is generated using {@see generateAttributeLabel()}. This method allows you to
     * explicitly specify attribute labels.
     *
     * Note, in order to inherit labels defined in the parent class, a child class needs to merge the parent labels
     * with child labels using functions such as `array_merge()`.
     *
     * @return array attribute labels (name => label)
     *
     * {@see generateAttributeLabel()}
     */
    public function attributeLabels(): array;

    /**
     * Returns the text label for the specified attribute.
     *
     * @param string $attribute the attribute name.
     *
     * @return string the attribute label.
     *
     * {@see generateAttributeLabel()}
     * {@see attributeLabels()}
     */
    public function attributeLabel(string $attribute): string;

    /**
     * Returns the attribute hints.
     *
     * Attribute hints are mainly used for display purpose. For example, given an attribute `isPublic`, we can declare
     * a hint `Whether the post should be visible for not logged in users`, which provides user-friendly description of
     * the attribute meaning and can be displayed to end users.
     *
     * Unlike label hint will not be generated, if its explicit declaration is omitted.
     *
     * Note, in order to inherit hints defined in the parent class, a child class needs to merge the parent hints with
     * child hints using functions such as `array_merge()`.
     *
     * @return array attribute hints (name => hint)
     */
    public function attributeHints(): array;

    /**
     * Returns the text hint for the specified attribute.
     *
     * @param string $attribute the attribute name.
     *
     * @return string the attribute hint.
     *
     * {@see attributeHints()}
     */
    public function attributeHint(string $attribute): string;

    /**
     * Returns a value indicating whether the attribute is required.
     *
     * This is determined by checking if the attribute is associated with a {@see \Yiisoft\Validator\Rule\Required}
     * validation rule.
     *
     * @param string $attribute attribute name.
     *
     * @return bool whether the attribute is required.
     */
    public function isAttributeRequired(string $attribute): bool;

    /**
     * Returns attribute values.
     *
     * @return array attribute values (name => value).
     */
    public function getAttributes(): array;

    /**
     * Returns the errors for all attributes.
     *
     * @return array errors for all attributes or the specified attribute. null is returned if no error.
     *
     * Note that when returning errors for all attributes, the result is a two-dimensional array, like the following:
     *
     * ```php
     * [
     *     'username' => [
     *         'Username is required.',
     *         'Username must contain only word characters.',
     *     ],
     *     'email' => [
     *         'Email address is invalid.',
     *     ]
     * ]
     * ```
     *
     * {@see firstErrors()}
     * {@see firstError()}
     */
    public function errors(): ?array;

    /**
     * Returns the errors for single attribute.
     *
     * @param string $attribute attribute name. Use null to retrieve errors for all attributes.
     *
     * @return array
     */
    public function error(string $attribute): ?array;

    /**
     * Returns the errors for all attributes as a one-dimensional array.
     *
     * @param bool $showAllErrors boolean, if set to true every error message for each attribute will be shown otherwise
     * only the first error message for each attribute will be shown.
     *
     * @return array errors for all attributes as a one-dimensional array. Empty array is returned if no error.
     *
     * {@see errors()}
     * {@see firstErrors(){}
     */
    public function errorSummary(bool $showAllErrors): array;

    /**
     * Returns a value indicating whether there is any validation error.
     *
     * @param string|null $attribute attribute name. Use null to check all attributes.
     *
     * @return bool whether there is any error.
     */
    public function hasErrors(?string $attribute = null): bool;

    /**
     * Returns the first error of every attribute in the model.
     *
     * @return array the first errors. The array keys are the attribute names, and the array values are the
     * corresponding error messages. An empty array will be returned if there is no error.
     *
     * {@see errors()}
     * {@see firstError()}
     */
    public function firstErrors(): array;

    /**
     * Returns the first error of the specified attribute.
     *
     * @param string $attribute attribute name.
     *
     * @return string the error message. Null is returned if no error.
     *
     * {@see errors()}
     * {@see firstErrors()}
     */
    public function firstError(string $attribute): ?string;

    /**
     * Returns the form name that this model class should use.
     *
     * The form name is mainly used by {\Yiisoft\Form\FormWidget} to determine how to name the input fields for the
     * attributes in a model. If the form name is "A" and an attribute name is "b", then the corresponding input name
     * would be "A[b]". If the form name is an empty string, then the input name would be "b".
     *
     * The purpose of the above naming schema is that for forms which contain multiple different models, the attributes
     * of each model are grouped in sub-arrays of the POST-data and it is easier to differentiate between them.
     *
     * By default, this method returns the model class name (without the namespace part) as the form name. You may
     * override it when the model is used in different forms.
     *
     * @return string the form name of this model class.
     *
     * {@see load()}
     */
    public function formName(): string;

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
     * `load()` gets the `'FormName'` from the model's [[formName()]] method (which you may override), unless the
     * `$formName` parameter is given. If the form name is empty, `load()` populates the model with the whole of
     * `$data`,
     * instead of `$data['FormName']`.
     *
     * Note, that the data being populated is subject to the safety check by [[setAttributes()]].
     *
     * @param array $data the data array to load, typically `$_POST` or `$_GET`.
     *
     * @return bool whether `load()` found the expected form in `$data`.
     */
    public function load(array $data): bool;
}
