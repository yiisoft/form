<?php

declare(strict_types=1);

namespace Yiisoft\Form;

/**
 * FormErrors represents a form errors collection.
 */
interface FormErrorsInterface
{
    /**
     * Add an error for the specified attribute.
     *
     * @param string $attribute Attribute name.
     * @param string $error Attribute error message.
     */
    public function addError(string $attribute, string $error): void;

    /**
     * Removes error for attributes.
     *
     * @param string $attribute Attribute name.
     */
    public function clear(string $attribute): void;

    /**
     * Returns errors for all attributes.
     *
     * @return array Errors for all attributes.
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
     * {@see getFirstErrors()}
     * {@see getFirstError()}
     *
     * @psalm-return array<string, array<string>>
     */
    public function getAllErrors(): array;

    /**
     * Returns errors for an attribute with a given name.
     *
     * @param string $attribute Attribute name.
     *
     * @return array
     *
     * @psalm-return string[]
     */
    public function getErrors(string $attribute): array;

    /**
     * Returns errors for all attributes as a one-dimensional array.
     *
     * @param array $onlyAttributes List of attributes to return errors.
     *
     * @return array errors for all attributes as a one-dimensional array. Empty array is returned if no error.
     *
     * {@see getErrors()}
     * {@see getFirstErrors(){}
     */
    public function getErrorSummary(array $onlyAttributes): array;

    /**
     * Returns the first error of every attribute in the collection.
     *
     * @return array the first error of every attribute in the collection. Empty array is returned if no error.
     */
    public function getErrorSummaryFirstErrors(): array;

    /**
     * Returns the first error of the specified attribute.
     *
     * @param string $attribute attribute name.
     *
     * @return string the error message. Empty string is returned if there is no error.
     *
     * {@see getErrors()}
     * {@see getFirstErrors()}
     */
    public function getFirstError(string $attribute): string;

    /**
     * Returns the first error of every attribute in the model.
     *
     * @return array the first errors. The array keys are the attribute names, and the array values are the
     * corresponding error messages. An empty array will be returned if there is no error.
     *
     * {@see getErrors()}
     * {@see getFirstError()}
     */
    public function getFirstErrors(): array;

    /**
     * Returns a value indicating whether there is any validation error.
     *
     * @param string|null $attribute attribute name. Use null to check all attributes.
     *
     * @return bool whether there is any error.
     */
    public function hasErrors(?string $attribute = null): bool;
}
