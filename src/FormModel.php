<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Closure;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionUnionType;
use RuntimeException;
use Throwable;
use Yiisoft\Strings\Inflector;
use Yiisoft\Strings\StringHelper;
use Yiisoft\Validator\PostValidationHookInterface;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RulesProviderInterface;

use function array_key_exists;
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
abstract class FormModel implements FormModelInterface, PostValidationHookInterface, RulesProviderInterface
{
    private array $attributes;
    private array $nullable = [];
    private ?FormErrorsInterface $formErrors = null;
    private ?Inflector $inflector = null;
    /** @psalm-var array<string, mixed> */
    private array $rawData = [];
    private bool $validated = false;

    public function __construct()
    {
        $this->attributes = $this->collectAttributes();
    }

    public function attributes(): array
    {
        return array_keys($this->attributes);
    }

    public function getAttributeHint(string $attribute, string ...$nested): string
    {
        $attributeHints = $this->getAttributeHints();
        $hint = $attributeHints[$attribute] ?? '';
        $nestedAttributeHint = (string) $this->getNestedAttributeValue('getAttributeHint', $attribute, ...$nested);

        return $nestedAttributeHint !== '' ? $nestedAttributeHint : $hint;
    }

    /**
     * @return string[]
     */
    public function getAttributeHints(): array
    {
        return [];
    }

    public function getAttributeLabel(string $attribute, string ...$nested): string
    {
        $label = $this->generateAttributeLabel($attribute);
        $labels = $this->getAttributeLabels();

        if (array_key_exists($attribute, $labels)) {
            $label = $labels[$attribute];
        }

        $nestedAttributeLabel = (string) $this->getNestedAttributeValue('getAttributeLabel', $attribute, ...$nested);

        return $nestedAttributeLabel !== '' ? $nestedAttributeLabel : $label;
    }

    /**
     * @return string[]
     */
    public function getAttributeLabels(): array
    {
        return [];
    }

    public function getAttributePlaceholder(string $attribute, string ...$nested): string
    {
        $attributePlaceHolders = $this->getAttributePlaceholders();
        $placeholder = $attributePlaceHolders[$attribute] ?? '';
        $nestedAttributePlaceholder = (string) $this->getNestedAttributeValue('getAttributePlaceholder', $attribute, ...$nested);

        return $nestedAttributePlaceholder !== '' ? $nestedAttributePlaceholder : $placeholder;
    }

    /**
     * @return string[]
     */
    public function getAttributePlaceholders(): array
    {
        return [];
    }

    public function getAttributeCastValue(string $attribute, string ...$nested): mixed
    {
        return $this->readProperty($attribute, ...$nested);
    }

    public function getAttributeRawValue(string $attribute, string ...$nested): mixed
    {
        [$attribute, $nested] = $this->getNestedAttribute($attribute, ...$nested);

        if ($nested !== null) {
            return $this->getNestedAttributeValue('getAttributeRawValue', $attribute, ...$nested);
        }

        return $this->rawData[$attribute] ?? null;
    }

    public function getAttributeValue(string $attribute, string ...$nested): mixed
    {
        return $this->getAttributeRawValue($attribute, ...$nested) ?? $this->getAttributeCastValue($attribute, ...$nested);
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

    public function hasAttribute(string $attribute, string ...$nested): bool
    {
        [$attribute, $nested] = $this->getNestedAttribute($attribute, ...$nested);

        if ($nested === null) {
            return array_key_exists($attribute, $this->attributes);
        }

        try {
            /** @var bool */
            return $this->getNestedAttributeValue('hasAttribute', $attribute, ...$nested);
        } catch (InvalidArgumentException $ex) {
            return false;
        } catch (Throwable $ex) {
            throw $ex;
        }
    }

    /**
     * @param array $data
     * @param string|null $formName
     *
     * @return bool
     *
     * @psalm-param array<string, string|array> $data
     */
    public function load(array $data, ?string $formName = null): bool
    {
        $this->rawData = $rawData = [];
        $scope = $formName ?? $this->getFormName();

        if ($scope === '' && !empty($data)) {
            $rawData = $data;
        } elseif (isset($data[$scope])) {
            /** @var array<string, string> */
            $rawData = $data[$scope];
        }

        foreach ($rawData as $name => $value) {
            $this->setAttribute($name, $value);
        }

        return $this->rawData !== [];
    }

    protected static function isEmpty(mixed $value): bool
    {
        return $value === null || $value === '' || $value === [];
    }

    protected function typeCast(string $attribute, mixed $value): mixed
    {
        if (isset($this->attributes[$attribute])) {
            if (static::isEmpty($value) && in_array($attribute, $this->nullable, true)) {
                return null;
            }

            return match ($this->attributes[$attribute]) {
                'bool' => (bool) $value,
                'float' => (float) $value,
                'int' => (int) $value,
                'string' => (string) $value,
                default => $value,
            };
        }

        return $value;
    }

    public function setAttribute(string $name, mixed $value): void
    {
        [$realName] = $this->getNestedAttribute($name);
        $this->rawData[$realName] = $value;

        if (isset($this->attributes[$realName])) {
            $this->writeProperty($name, $this->typeCast($realName, $value));
        }
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

    public function getRules(): array
    {
        return [];
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

            /** @var ReflectionNamedType|ReflectionUnionType|null $type */
            $type = $property->getType();
            $name = $property->getName();

            if ($type instanceof ReflectionUnionType) {
                $attributes[$name] = '';
            } else {
                $attributes[$name] = $type !== null ? $type->getName() : '';
            }

            if ($type && $type->allowsNull()) {
                $this->nullable[] = $name;
            }
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
                $this->getFormErrors()->addError($attribute, $error);
            }
        }
    }

    private function getInflector(): Inflector
    {
        if ($this->inflector === null) {
            $this->inflector = new Inflector();
        }
        return $this->inflector;
    }

    /**
     * Generates a user-friendly attribute label based on the give attribute name.
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
        return StringHelper::uppercaseFirstCharacterInEachWord(
            $this->getInflector()->toWords($name)
        );
    }

    private function readProperty(string $attribute, string ...$nested): mixed
    {
        $class = static::class;

        [$attribute, $nested] = $this->getNestedAttribute($attribute, ...$nested);

        if (!property_exists($class, $attribute)) {
            throw new InvalidArgumentException("Undefined property: \"$class::$attribute\".");
        }

        /** @psalm-suppress MixedMethodCall */
        $getter = static function (FormModelInterface $class, string $attribute, ?array $nested): mixed {
            return match ($nested) {
                null => $class->$attribute,
                default => $class->$attribute->getAttributeCastValue(...$nested),
            };
        };

        $getter = Closure::bind($getter, null, $this);

        /** @var Closure $getter */
        return $getter($this, $attribute, $nested);
    }

    private function writeProperty(string $attribute, mixed $value): void
    {
        [$attribute, $nested] = $this->getNestedAttribute($attribute);

        /**
         * @psalm-suppress MixedMethodCall
         */
        $setter = static function (FormModelInterface $class, string $attribute, mixed $value, ?array $nested): void {
            if (is_a($class->$attribute, __CLASS__)) {
                if ($nested) {
                    /** @var array<array-key,string> $nested */
                    $class->$attribute->setAttribute(implode('.', $nested), $value);
                } elseif (is_array($value)) {
                    $class->$attribute->load($value, '');
                } else {
                    throw new RuntimeException('$value must be array for using as nested attribute');
                }
            } else {
                $class->$attribute = $value;
            }
        };

        $closure = Closure::bind($setter, null, $this);
        /** @var Closure $closure */
        $closure($this, $attribute, $value, $nested);
    }

    /**
     * @return string[]
     *
     * @psalm-return array{0: string, 1: null|string[]}
     */
    private function getNestedAttribute(string $attribute, string ...$nested): array
    {
        if (!$nested) {
            if (!str_contains($attribute, '.')) {
                return [$attribute, null];
            }

            $nested = explode('.', $attribute);
            $attribute = array_shift($nested);
        }

        /** @var string */
        $attributeNested = $this->attributes[$attribute] ?? '';

        if (!is_subclass_of($attributeNested, self::class)) {
            throw new InvalidArgumentException("Attribute \"$attribute\" is not a nested attribute.");
        }

        if (!property_exists($attributeNested, $nested[0])) {
            throw new InvalidArgumentException("Undefined property: \"$attributeNested::$nested[0]\".");
        }

        return [$attribute, $nested];
    }

    private function getNestedAttributeValue(string $method, string $attribute, string ...$nested): mixed
    {
        $result = '';

        [$attribute, $nested] = $this->getNestedAttribute($attribute, ...$nested);

        if ($nested !== null) {
            /** @var FormModelInterface $attributeNestedValue */
            $attributeNestedValue = $this->getAttributeCastValue($attribute);
            /** @var string */
            $result = $attributeNestedValue->$method(...$nested);
        }

        return $result;
    }

    public function isValidated(): bool
    {
        return $this->validated;
    }
}
