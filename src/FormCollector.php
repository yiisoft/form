<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Exception;
use InvalidArgumentException;
use ReflectionAttribute;
use ReflectionNamedType;
use ReflectionObject;
use Yiisoft\Validator\RuleInterface;

final class FormCollector
{
    private array $attributes;
    private array $rules = [];

    public function __construct(private FormModelInterface $formModel)
    {
        [$this->attributes, $this->rules] = $this->collectAttributes();
    }

    public function attributes(): array
    {
        return $this->attributes;
    }

    public function getType(string $attribute): string
    {
        return match (isset($this->attributes[$attribute]) && is_string($this->attributes[$attribute])) {
            true => $this->attributes[$attribute],
            false => '',
        };
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * Returns the type of the given value.
     */
    public function phpTypeCast(string $name, mixed $value): mixed
    {
        if (!$this->formModel->hasAttribute($name)) {
            return null;
        }

        if ($value === null) {
            return null;
        }

        try {
            return match ($this->attributes[$name]) {
                'bool' => (bool) $value,
                'float' => (float) $value,
                'int' => (int) $value,
                'string' => (string) $value,
                default => $value,
            };
        } catch (Exception $e) {
            throw new InvalidArgumentException(
                sprintf('The value is not of type "%s".', (string) $this->attributes[$name])
            );
        }
    }

    /**
     * Returns the list of attribute types indexed by attribute names.
     *
     * By default, this method returns all non-static properties of the class.
     *
     * @return array list of attribute types indexed by attribute names.
     *
     * @psalm-suppress UndefinedClass
     */
    private function collectAttributes(): array
    {
        $reflection = new ReflectionObject($this->formModel);
        $attributes = [];
        $rules = [];

        foreach ($reflection->getProperties() as $property) {
            if ($property->isStatic() === false) {
                /** @var ReflectionNamedType|null $type */
                $type = $property->getType();
                $attributes[$property->getName()] = $type !== null ? $type->getName() : '';
                $attributeRules = $property->getAttributes(RuleInterface::class, ReflectionAttribute::IS_INSTANCEOF);

                foreach ($attributeRules as $attributeRule) {
                    $rules[$property->getName()][] = $attributeRule->newInstance();
                }
            }
        }

        return [$attributes, $rules];
    }
}
