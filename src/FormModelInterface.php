<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Yiisoft\Validator\DataSetInterface;
use Yiisoft\Validator\Result;

/**
 * FormModelInterface model represents an HTML form: its data, validation and presentation.
 */
interface FormModelInterface extends DataSetInterface
{
    /**
     * Return array with names of all attributes
     *
     * @return array
     */
    public function attributes(): array;

    /**
     * If there is such attribute in the set.
     *
     * @param string $attribute
     *
     * @return bool
     */
    public function hasAttribute(string $attribute): bool;

    public function getValidationResult(): Result;

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
     * Returns the text label for the specified attribute.
     *
     * @param string $attribute the attribute name.
     *
     * @return string the attribute label.
     */
    public function getAttributeLabel(string $attribute): string;

    /**
     * Returns the attribute labels.
     *
     * Attribute labels are mainly used for display purpose. For example, given an attribute `firstName`, we can
     * declare a label `First Name` which is more user-friendly and can be displayed to end users.
     *
     * By default, an attribute label is generated automatically. This method allows you to
     * explicitly specify attribute labels.
     *
     * Note, in order to inherit labels defined in the parent class, a child class needs to merge the parent labels
     * with child labels using functions such as `array_merge()`.
     *
     * @return array attribute labels (name => label)
     *
     * {@see \Yiisoft\Form\FormModel::getAttributeLabel()}
     */
    public function getAttributeLabels(): array;

    /**
     * Returns the text hint for the specified attribute.
     *
     * @param string $attribute the attribute name.
     *
     * @return string the attribute hint.
     */
    public function getAttributeHint(string $attribute): string;

    /**
     * Returns the attribute hints.
     *
     * Attribute hints are mainly used for display purpose. For example, given an attribute `isPublic`, we can declare
     * a hint `Whether the post should be visible for not logged-in users`, which provides user-friendly description of
     * the attribute meaning and can be displayed to end users.
     *
     * Unlike label hint will not be generated, if its explicit declaration is omitted.
     *
     * Note, in order to inherit hints defined in the parent class, a child class needs to merge the parent hints with
     * child hints using functions such as `array_merge()`.
     *
     * @return array attribute hints (name => hint)
     */
    public function getAttributeHints(): array;

    /**
     * Returns the text placeholder for the specified attribute.
     *
     * @param string $attribute the attribute name.
     *
     * @return string the attribute placeholder.
     */
    public function getAttributePlaceholder(string $attribute): string;

    /**
     * Returns the attribute placeholders.
     *
     * @return array attribute placeholder (name => placeholder)
     */
    public function getAttributePlaceholders(): array;
}
