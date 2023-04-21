<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Closure;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionNamedType;
use Yiisoft\Form\Helper\FormHelper;
use Yiisoft\Validator\DataSetInterface;
use Yiisoft\Validator\PostValidationHookInterface;
use Yiisoft\Validator\Result;

use function array_keys;
use function explode;
use function is_subclass_of;
use function property_exists;
use function str_contains;
use function strrchr;
use function substr;

/**
 * Form model represents an HTML form: its data, validation and presentation.
 */
abstract class FormModel implements
    DataSetInterface,
    FormModelInterface,
    PostValidationHookInterface
{
    private array $attributeTypes;
    private ?FormErrorsInterface $formErrors = null;
    private array $rawData = [];
    private bool $validated = false;

    public function __construct()
    {
        $this->attributeTypes = $this->collectAttributes();
    }

    public function attributes(): array
    {
        return array_keys($this->attributeTypes);
    }

    public function getAttributeHint(string $attribute): string
    {
        $attributeHints = $this->getAttributeHints();
        $hint = $attributeHints[$attribute] ?? '';
        $nestedAttributeHint = $this->getNestedAttributeValue('getAttributeHint', $attribute);

        return $nestedAttributeHint !== '' ? $nestedAttributeHint : $hint;
    }

    /**
     * @return string[]
     */
    public function getAttributeHints(): array
    {
        return [];
    }

    public function getAttributeLabel(string $attribute): string
    {
        return FormHelper::getAttributeLabel($this, $attribute);
    }

    public function getAttributeLabels(): array
    {
        return [];
    }

    public function getAttributePlaceholder(string $attribute): string
    {
        $attributePlaceHolders = $this->getAttributePlaceholders();
        $placeholder = $attributePlaceHolders[$attribute] ?? '';
        $nestedAttributePlaceholder = $this->getNestedAttributeValue('getAttributePlaceholder', $attribute);

        return $nestedAttributePlaceholder !== '' ? $nestedAttributePlaceholder : $placeholder;
    }

    /**
     * @return string[]
     */
    public function getAttributePlaceholders(): array
    {
        return [];
    }

    public function getAttributeCastValue(string $attribute): mixed
    {
        return FormHelper::getValue($this, $attribute);
    }

    public function getAttributeValue(string $attribute): mixed
    {
        return $this->rawData[$attribute] ?? $this->getAttributeCastValue($attribute);
    }

    /**
     * @return FormErrorsInterface Get FormErrors object.
     */
    public function getFormErrors(): FormErrorsInterface
    {
        if ($this->formErrors === null) {
            $this->formErrors = new FormErrors();
        }

        return $this->formErrors;
    }

    /**
     * @return string Returns classname without a namespace part or empty string when class is anonymous
     */
    public function getFormName(): string
    {
        if (str_contains(static::class, '@anonymous')) {
            return '';
        }

        $className = strrchr(static::class, '\\');
        if ($className === false) {
            return static::class;
        }

        return substr($className, 1);
    }

    public function hasAttribute(string $attribute): bool
    {
        return FormHelper::hasAttribute($this, $attribute);
    }

    public function load(array|object|null $data, ?string $formName = null): bool
    {
        if (!is_array($data)) {
            return false;
        }

        $this->rawData = [];
        $scope = $formName ?? $this->getFormName();

        if ($scope === '' && !empty($data)) {
            $this->rawData = $data;
        } elseif (isset($data[$scope])) {
            if (!is_array($data[$scope])) {
                return false;
            }
            $this->rawData = $data[$scope];
        }

        /**
         * @var mixed $value
         */
        foreach ($this->rawData as $name => $value) {
            $this->setAttribute((string) $name, $value);
        }

        return $this->rawData !== [];
    }

    public function setAttribute(string $name, mixed $value): void
    {
        if ($this->hasAttribute($name) === false) {
            return;
        }

        [$realName] = $this->getNestedAttribute($name);

        if ($value !== null) {
            /** @var mixed */
            $value = match ($this->attributeTypes[$realName]) {
                'bool' => (bool) $value,
                'float' => (float) $value,
                'int' => (int) $value,
                'string' => (string) $value,
                default => $value,
            };
        }

        $this->writeProperty($name, $value);
    }

    public function processValidationResult(Result $result): void
    {
        foreach ($result->getErrorMessagesIndexedByAttribute() as $attribute => $errors) {
            if ($this->hasAttribute($attribute)) {
                $this->addErrors([$attribute => $errors]);
            }
        }

        $this->validated = true;
    }

    public function setFormErrors(FormErrorsInterface $formErrors): void
    {
        $this->formErrors = $formErrors;
    }

    /**
     * Returns the list of attribute types indexed by attribute names.
     *
     * By default, this method returns all non-static properties of the class.
     *
     * @return array list of attribute types indexed by attribute names.
     */
    protected function collectAttributes(): array
    {
        $class = new ReflectionClass($this);
        $attributes = [];

        foreach ($class->getProperties() as $property) {
            if ($property->isStatic()) {
                continue;
            }

            /** @var ReflectionNamedType|null $type */
            $type = $property->getType();

            $attributes[$property->getName()] = $type !== null ? $type->getName() : '';
        }

        return $attributes;
    }

    /**
     * @psalm-param  non-empty-array<string, non-empty-list<string>> $items
     */
    private function addErrors(array $items): void
    {
        foreach ($items as $attribute => $errors) {
            foreach ($errors as $error) {
                $this
                    ->getFormErrors()
                    ->addError($attribute, $error);
            }
        }
    }

    private function writeProperty(string $attribute, mixed $value): void
    {
        [$attribute, $nested] = $this->getNestedAttribute($attribute);

        /** @psalm-suppress MixedMethodCall */
        $setter = static function (FormModelInterface $class, string $attribute, mixed $value, ?string $nested): void {
            match ($nested) {
                null => $class->$attribute = $value,
                default => $class->$attribute->setAttribute($nested, $value),
            };
        };

        $setter = Closure::bind($setter, null, $this);

        /** @var Closure $setter */
        $setter($this, $attribute, $value, $nested);
    }

    /**
     * @return string[]
     *
     * @psalm-return array{0: string, 1: null|string}
     */
    private function getNestedAttribute(string $attribute): array
    {
        if (!str_contains($attribute, '.')) {
            return [$attribute, null];
        }

        /** @psalm-suppress PossiblyUndefinedArrayOffset Condition above guarantee that attribute contains dot */
        [$attribute, $nested] = explode('.', $attribute, 2);

        /** @var string */
        $attributeNested = $this->attributeTypes[$attribute] ?? '';

        if (!is_subclass_of($attributeNested, self::class)) {
            throw new InvalidArgumentException("Attribute \"$attribute\" is not a nested attribute.");
        }

        if (!property_exists($attributeNested, $nested)) {
            throw new InvalidArgumentException("Undefined property: \"$attributeNested::$nested\".");
        }

        return [$attribute, $nested];
    }

    private function getNestedAttributeValue(string $method, string $attribute): string
    {
        $result = '';

        [$attribute, $nested] = $this->getNestedAttribute($attribute);

        if ($nested !== null) {
            /** @var FormModelInterface $attributeNestedValue */
            $attributeNestedValue = $this->getAttributeCastValue($attribute);
            /** @var string */
            $result = $attributeNestedValue->$method($nested);
        }

        return $result;
    }

    public function isValidated(): bool
    {
        return $this->validated;
    }

    public function getData(): array
    {
        return $this->rawData;
    }
}
