<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Closure;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use Yiisoft\Strings\Inflector;
use Yiisoft\Strings\StringHelper;
use Yiisoft\Validator\DataSetInterface;
use Yiisoft\Validator\PostValidationHookInterface;
use Yiisoft\Validator\Result;

use function array_key_exists;
use function array_keys;
use function array_slice;
use function explode;
use function is_array;
use function is_object;
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
    private const META_LABEL = 1;
    private const META_HINT = 2;
    private const META_PLACEHOLDER = 3;

    private static ?Inflector $inflector = null;

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
        return $this->readAttributeMetaValue(self::META_HINT, $attribute) ?? '';
    }

    public function getAttributeHints(): array
    {
        return [];
    }

    public function getAttributeLabel(string $attribute): string
    {
        return $this->readAttributeMetaValue(self::META_LABEL, $attribute) ?? $this->generateAttributeLabel($attribute);
    }

    public function getAttributeLabels(): array
    {
        return [];
    }

    public function getAttributePlaceholder(string $attribute): string
    {
        return $this->readAttributeMetaValue(self::META_PLACEHOLDER, $attribute) ?? '';
    }

    public function getAttributePlaceholders(): array
    {
        return [];
    }

    public function getAttributeCastValue(string $attribute): mixed
    {
        return $this->readAttributeValue($attribute);
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
        try {
            $this->readAttributeValue($attribute);
        } catch (InvalidAttributeException) {
            return false;
        }
        return true;
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

    public function isValidated(): bool
    {
        return $this->validated;
    }

    public function getData(): array
    {
        return $this->rawData;
    }

    /**
     * @throws InvalidAttributeException
     */
    private function readAttributeValue(string $attribute): mixed
    {
        $path = $this->normalizePath($attribute);

        $value = $this;
        $keys = [[$this::class, $this]];
        foreach ($path as $key) {
            $keys[] = [$key, $value];

            if (is_array($value)) {
                if (array_key_exists($key, $value)) {
                    /** @var mixed $value */
                    $value = $value[$key];
                    continue;
                }
                throw $this->createNotFoundException($keys);
            }

            if (is_object($value)) {
                $class = new ReflectionClass($value);
                try {
                    $property = $class->getProperty($key);
                } catch (ReflectionException) {
                    throw $this->createNotFoundException($keys);
                }
                if ($property->isStatic()) {
                    throw $this->createNotFoundException($keys);
                }
                if (PHP_VERSION_ID < 80100) {
                    $property->setAccessible(true);
                }
                /** @var mixed $value */
                $value = $property->getValue($value);
                continue;
            }

            array_pop($keys);
            throw new InvalidAttributeException(
                sprintf('Attribute "%s" is not a nested attribute.', $this->makePathString($keys))
            );
        }

        return $value;
    }

    private function readAttributeMetaValue(int $metaKey, string $attribute): ?string
    {
        $path = $this->normalizePath($attribute);

        $value = $this;
        $n = 0;
        foreach ($path as $key) {
            if ($value instanceof FormModelInterface) {
                $nestedAttribute = implode('.', array_slice($path, $n));
                $data = match ($metaKey) {
                    self::META_LABEL => $value->getAttributeLabels(),
                    self::META_HINT => $value->getAttributeHints(),
                    self::META_PLACEHOLDER => $value->getAttributePlaceholders(),
                    default => throw new InvalidArgumentException('Invalid meta key.'),
                };
                if (array_key_exists($nestedAttribute, $data)) {
                    return $data[$nestedAttribute];
                }
            }

            $class = new ReflectionClass($value);
            try {
                $property = $class->getProperty($key);
            } catch (ReflectionException) {
                return null;
            }
            if ($property->isStatic()) {
                return null;
            }

            if (PHP_VERSION_ID < 80100) {
                $property->setAccessible(true);
            }
            /** @var mixed $value */
            $value = $property->getValue($value);
            if (!is_object($value)) {
                return null;
            }

            $n++;
        }

        return null;
    }

    /**
     * Generates a user-friendly attribute label based on the give attribute name.
     *
     * This is done by replacing underscores, dashes and dots with blanks and changing the first letter of each word to
     * upper case.
     *
     * For example, 'department_name' or 'DepartmentName' will generate 'Department Name'.
     *
     * @param string $attribute The attribute name.
     *
     * @return string The attribute label.
     */
    private function generateAttributeLabel(string $attribute): string
    {
        if (self::$inflector === null) {
            self::$inflector = new Inflector();
        }

        return StringHelper::uppercaseFirstCharacterInEachWord(
            self::$inflector->toWords($attribute)
        );
    }

    /**
     * @return string[]
     */
    private function normalizePath(string $attribute): array
    {
        $attribute = str_replace(['][', '['], '.', rtrim($attribute, ']'));
        return StringHelper::parsePath($attribute);
    }

    /**
     * @psalm-param list<array{0:int|string, 1:mixed}> $keys
     */
    private function createNotFoundException(array $keys): InvalidArgumentException
    {
        return new InvalidAttributeException('Undefined property: "' . $this->makePathString($keys) . '".');
    }

    /**
     * @psalm-param list<array{0:int|string, 1:mixed}> $keys
     */
    private function makePathString(array $keys): string
    {
        $path = '';
        foreach ($keys as $key) {
            if ($path !== '') {
                if (is_object($key[1])) {
                    $path .= '::' . $key[0];
                } elseif (is_array($key[1])) {
                    $path .= '[' . $key[0] . ']';
                }
            } else {
                $path = (string) $key[0];
            }
        }
        return $path;
    }
}
