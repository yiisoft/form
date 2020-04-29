<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Yiisoft\Strings\Inflector;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Validator;

abstract class Form implements FormInterface
{
    private array $attributes;
    private array $attributesLabels;
    private array $attributesErrors = [];
    private ?Inflector $inflector = null;

    public function __construct()
    {
        $this->attributes = $this->attributes();
        $this->attributesLabels = $this->attributeLabels();
    }

    public function isAttributeRequired(string $attribute): bool
    {
        $validators = $this->rules()[$attribute] ?? [];

        foreach ($validators as $validator) {
            if ($validator instanceof Required) {
                return true;
            }
        }

        return false;
    }

    public function getAttributeValue(string $attribute)
    {
        return $this->readProperty($attribute);
    }

    public function attributeHint(string $attribute): string
    {
        $hints = $this->attributeHints();

        return $hints[$attribute] ?? '';
    }

    public function attributeHints(): array
    {
        return [];
    }

    public function attributeLabel(string $attribute): string
    {
        return $this->attributesLabels[$attribute] ?? $this->generateAttributeLabel($attribute);
    }

    public function formName(): string
    {
        return '';
    }

    public function hasAttribute(string $attribute): bool
    {
        return \array_key_exists($attribute, $this->attributes);
    }

    public function error(string $attribute): array
    {
        return $this->attributesErrors[$attribute] ?? [];
    }

    public function errors(): array
    {
        return $this->attributesErrors ?? [];
    }

    public function errorSummary(bool $showAllErrors): array
    {
        $lines = [];
        $errors = $showAllErrors ? $this->errors() : [$this->firstErrors()];

        foreach ($errors as $error) {
            $lines = \array_merge($lines, $error);
        }

        return $lines;
    }

    public function firstError(string $attribute): string
    {
        return isset($this->attributesErrors[$attribute]) ? reset($this->attributesErrors[$attribute]) : '';
    }

    public function firstErrors(): array
    {
        if (empty($this->attributesErrors)) {
            return [];
        }

        $errors = [];

        foreach ($this->attributesErrors as $name => $es) {
            if (!empty($es)) {
                $errors[$name] = \reset($es);
            }
        }

        return $errors;
    }

    public function hasErrors(?string $attribute = null): bool
    {
        return $attribute === null ? !empty($this->attributesErrors) : isset($this->attributesErrors[$attribute]);
    }

    public function load(array $data): bool
    {
        $result = false;

        $scope = $this->formName();

        if ($scope === '' && !empty($data)) {
            $this->setAttributes($data);
            $result = true;
        } elseif (isset($data[$scope])) {
            $this->setAttributes($data[$scope]);
            $result = true;
        }

        return $result;
    }

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by {@see \Yiisoft\Validator\Validator} to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * Each rule is an array with the following structure:
     *
     * ```php
     * public function rules(): array
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
     *       (new \Yiisoft\Validator\Rule\HasLength())
     *       ->min(4)
     *       ->max(40)
     *       ->tooShortMessage('Is too short.')
     *       ->tooLongMessage('Is too long.'),
     *       new \Yiisoft\Validator\Rule\Email()
     *   ];
     * }
     * ```
     *
     * @return array validation rules
     */
    protected function rules(): array
    {
        return [
        ];
    }

    public function setAttributes(array $values): void
    {
        foreach ($values as $name => $value) {
            if (isset($this->attributes[$name])) {
                switch ($this->attributes[$name]) {
                    case 'bool':
                        $this->writeProperty($name, (bool) $value);
                        break;
                    case 'int':
                        $this->writeProperty($name, (int) $value);
                        break;
                    default:
                        $this->writeProperty($name, $value);
                        break;
                }
            }
        }
    }

    public function validate(): bool
    {
        $this->clearErrors();

        $rules = $this->rules();

        if (!empty($rules)) {
            $results = (new Validator($rules))->validate($this);

            foreach ($results as $attribute => $result) {
                if ($result->isValid() === false) {
                    $this->addErrors([$attribute => $result->getErrors()]);
                }
            }
        }

        return !$this->hasErrors();
    }

    private function addErrors(array $items): void
    {
        foreach ($items as $attribute => $errors) {
            foreach ((array)$errors as $error) {
                $this->attributesErrors[$attribute][] = $error;
            }
        }
    }

    /**
     * Returns the list of attribute types indexed by attribute names.
     *
     * By default, this method returns all non-static properties of the class.
     *
     * @throws \ReflectionException
     *
     * @return array list of attribute types indexed by attribute names.
     */
    private function attributes(): array
    {
        $class = new \ReflectionClass($this);

        foreach ($class->getProperties() as $property) {
            if (!$property->isStatic()) {
                $type = (new \ReflectionProperty($property->class, $property->name))->getType();

                if ($type !== null) {
                    $this->attributes[$property->getName()] = $type->getName();
                } else {
                    throw new \InvalidArgumentException(
                        "You must specify the type hint for \"$property->class\" class."
                    );
                }
            }
        }

        return $this->attributes;
    }

    private function clearErrors(?string $attribute = null): void
    {
        if ($attribute === null) {
            $this->attributesErrors = [];
        } else {
            unset($this->attributesErrors[$attribute]);
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
        if ($this->inflector === null) {
            $this->inflector = new Inflector();
        }

        return $this->inflector->camel2words($name, true);
    }

    private function readProperty(string $attribute)
    {
        $getter = fn ($class, $attribute) => $class->$attribute;
        $getter = \Closure::bind($getter, null, $this);

        return $getter($this, $attribute);
    }

    private function writeProperty(string $attribute, $value): void
    {
        $setter = fn ($class, $attribute, $value) => $class->$attribute = $value;
        $setter = \Closure::bind($setter, null, $this);

        $setter($this, $attribute, $value);
    }
}
