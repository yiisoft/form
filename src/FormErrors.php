<?php

declare(strict_types=1);

namespace Yiisoft\Form;

class FormErrors
{
    private array $attributesErrors;

    public function __construct(array $attributesErrors = [])
    {
        $this->attributesErrors = $attributesErrors;
    }

    /**
     * Returns the errors for single attribute.
     *
     * @param string $attribute attribute name. Use null to retrieve errors for all attributes.
     *
     * @return array
     */
    public function getForAttribute(string $attribute): array
    {
        return $this->attributesErrors[$attribute] ?? [];
    }

    /**
     * Returns the errors for all attributes as a one-dimensional array.
     *
     * @param bool $showAllErrors boolean, if set to true every error message for each attribute will be shown otherwise
     * only the first error message for each attribute will be shown.
     *
     * @return array errors for all attributes as a one-dimensional array. Empty array is returned if no error.
     *
     * {@see getErrors()}
     * {@see getFirstErrors(){}
     */
    public function getErrorSummary(bool $showAllErrors): array
    {
        $lines = [];
        $errors = $showAllErrors ? $this->asArray() : [$this->getFirstErrors()];

        foreach ($errors as $error) {
            $lines = array_merge($lines, $error);
        }

        return $lines;
    }

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
    public function getFirstError(string $attribute): string
    {
        if (empty($this->attributesErrors[$attribute])) {
            return '';
        }

        return reset($this->attributesErrors[$attribute]);
    }

    /**
     * Returns the first error of every attribute in the model.
     *
     * @return array the first errors. The array keys are the attribute names, and the array values are the
     * corresponding error messages. An empty array will be returned if there is no error.
     *
     * {@see getErrors()}
     * {@see getFirstError()}
     */
    public function getFirstErrors(): array
    {
        if (empty($this->attributesErrors)) {
            return [];
        }

        $errors = [];

        foreach ($this->attributesErrors as $name => $es) {
            if (!empty($es)) {
                $errors[$name] = reset($es);
            }
        }

        return $errors;
    }

    /**
     * Returns a value indicating whether there is any validation error.
     *
     * @param string|null $attribute attribute name. Use null to check all attributes.
     *
     * @return bool whether there is any error.
     */
    public function hasErrors(?string $attribute = null): bool
    {
        return $attribute === null ? !empty($this->attributesErrors) : isset($this->attributesErrors[$attribute]);
    }

    /**
     * Add error for the specified attribute.
     *
     * @param string $attribute attribute name.
     * @param string $error attribute error message.
     */
    public function add(string $attribute, string $error): void
    {
        $this->attributesErrors[$attribute][] = $error;
    }

    public function clear(): void
    {
        $this->attributesErrors = [];
    }

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
     * {@see getFirstErrors()}
     * {@see getFirstError()}
     */
    public function asArray(): array
    {
        return $this->attributesErrors;
    }
}
