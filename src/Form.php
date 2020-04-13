<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Yiisoft\Strings\Inflector;

abstract class Form implements FormInterface
{
    private array $attributes = [];
    private array $attributesLabels = [];
    private array $errors = [];

    public function __construct()
    {
        $this->attributes = $this->attributes();
    }

    /**
     * Adds a new error to the specified attribute.
     *
     * @param string $attribute attribute name
     * @param string $error new error message
     */
    public function addError(string $attribute, string $error): void
    {
        $this->errors[$attribute][] = $error;
    }

    /**
     * Adds a list of errors.
     *
     * @param array $items a list of errors. The array keys must be attribute names.
     * The array values should be error messages. If an attribute has multiple errors, these errors must be given in
     * terms of an array.
     *
     * You may use the result of {@see getErrors()} as the value for this parameter.
     */
    public function addErrors(array $items): void
    {
        foreach ($items as $attribute => $errors) {
            if (\is_array($errors)) {
                foreach ($errors as $error) {
                    $this->addError($attribute, $error);
                }
            } else {
                $this->addError($attribute, $errors);
            }
        }
    }

    /**
     * Returns the list of attribute names.
     *
     * By default, this method returns all private non-static properties of the class.
     *
     * @return array list of attribute names.
     */
    public function attributes(): array
    {
        $class = new \ReflectionClass($this);

        $type = null;

        foreach ($class->getProperties(\ReflectionProperty::IS_PRIVATE) as $property) {
            if (!$property->isStatic()) {
                $type = (new \ReflectionProperty($property->class, $property->name))->getType();

                if ($type !== null) {
                    $this->attributes[$property->getName()] = $type->getName();
                } else {
                    throw new \InvalidArgumentException("You must specify the TypeHint for Class: $property->class");
                }
            }
        }

        return $this->attributes;
    }

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
    public function attributesLabels(): array
    {
        return [];
    }

    /**
     * Removes errors for all attributes or a single attribute.
     *
     * @param string|null $attribute attribute name. Use null to remove errors for all attributes.
     */
    public function clearErrors(?string $attribute = null): void
    {
        if ($attribute === null) {
            $this->errors = [];
        } else {
            unset($this->errors[$attribute]);
        }
    }

    /**
     * Returns attribute values.
     *
     * @return array attribute values (name => value).
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Returns the text hint for the specified attribute.
     *
     * @param string $attribute the attribute name.
     *
     * @return string the attribute hint.
     *
     * {@see getAttributesHints()}
     */
    public function getAttributeHint(string $attribute): string
    {
        $hints = $this->getAttributesHints();

        return isset($hints[$attribute]) ? $hints[$attribute] : '';
    }

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
    public function getAttributesHints(): array
    {
        return [];
    }

    /**
     * Returns the text label for the specified attribute.
     *
     * @param string $attribute the attribute name.
     *
     * @return string the attribute label.
     *
     * {@see generateAttributeLabel()}
     * {@see attributesLabels()}
     */
    public function getAttributeLabel(string $attribute): string
    {
        $this->attributesLabels = $this->getAttributesLabels();

        return isset($this->attributesLabels[$attribute])
            ? $this->attributesLabels[$attribute]
            : $this->generateAttributeLabel($attribute);
    }

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
     * @return string|null the form name of this model class.
     *
     * {@see load()}
     */
    public function getFormname(): ?string
    {
        return null;
    }

    /**
     * Returns the errors for all attributes or a single attribute.
     *
     * @param string|null $attribute attribute name. Use null to retrieve errors for all attributes.
     * @property array An array of errors for all attributes. Empty array is returned if no error. The result is a
     * two-dimensional array. {@see getErrors()} for detailed description.
     * @return array errors for all attributes or the specified attribute. Empty array is returned if no error.
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
    public function getErrors(?string $attribute = null): array
    {
        if ($attribute === null) {
            return $this->errors === null ? [] : $this->errors;
        }

        return isset($this->errors[$attribute]) ? $this->errors[$attribute] : [];
    }

    /**
     * Returns the first error of the specified attribute.
     *
     * @param string $attribute attribute name.
     *
     * @return string|null the error message. Null is returned if no error.
     *
     * {@see getErrors()}
     * {@see getFirstErrors()}
     */
    public function getFirstError(string $attribute): string
    {
        return isset($this->errors[$attribute]) ? reset($this->errors[$attribute]) : '';
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
        if (empty($this->errors)) {
            return [];
        }

        $errors = [];

        foreach ($this->errors as $name => $es) {
            if (!empty($es)) {
                $errors[$name] = \reset($es);
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
        return $attribute === null ? !empty($this->errors) : isset($this->errors[$attribute]);
    }

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
    public function load($data): bool
    {
        $result = false;

        $scope = $this->getFormName();

        if ($scope === null && !empty($data)) {
            $this->setAttributes($data);
            $result = true;
        } elseif (isset($data[$scope])) {
            $this->setAttributes($data[$scope]);
            $result = true;
        }

        return $result;
    }

    /**
     * Sets the attribute values in a massive way.
     *
     * @param array $values attribute values (name => value) to be assigned to the model.

     * {@see safeAttributes()}
     * {@see attributes()}
     */
    public function setAttributes($values): void
    {
        if (\is_array($values)) {
            foreach ($values as $name => $value) {
                if (isset($this->attributes[$name])) {
                    switch ($this->attributes[$name]) {
                        case 'bool':
                            $this->$name((bool) $value);
                            break;
                        case 'int':
                            $this->$name((int) $value);
                            break;
                        default:
                            $this->$name($value);
                            break;
                    }
                }
            }
        }
    }

    /**
     * Generates a user friendly attribute label based on the give attribute name.
     *
     * This is done by replacing underscores, dashes and dots with blanks and changing the first letter of each word to
     * upper case.
     *
     * For example, 'department_name' or 'DepartmentName' will generate 'Department Name'.
     *
     * @param string $name the column name.
     *
     * @return string the attribute label.
     */
    private function generateAttributeLabel(string $name): string
    {
        $inflector = new Inflector();

        return $inflector->camel2words($name, true);
    }
}
