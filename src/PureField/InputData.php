<?php

declare(strict_types=1);

namespace Yiisoft\Form\PureField;

use Yiisoft\Form\Field\Base\InputData\InputDataInterface;

/**
 * Simple input data implementation that can be used within this package. All parameters are passed from outer scope.
 * Regarding validation, it does not support state and rules, stores the result errors only. For more advanced
 * implementation take a look at form model ({@link https://github.com/yiisoft/form-model}) package.
 *
 * To simplify adding to field, {@see Field} helper or {@see FieldFactory} can be used.
 */
final class InputData implements InputDataInterface
{
    /**
     * @param string[] $validationErrors
     *
     * @psalm-param list<string> $validationErrors
     */
    public function __construct(
        private readonly ?string $name = null,
        private readonly mixed $value = null,
        private readonly ?string $label = null,
        private readonly ?string $hint = null,
        private readonly ?string $placeholder = null,
        private readonly ?string $id = null,
        private readonly mixed $validationRules = null,
        private readonly ?array $validationErrors = null,
    ) {}

    public function getValidationRules(): mixed
    {
        return $this->validationRules;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getHint(): ?string
    {
        return $this->hint;
    }

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function isValidated(): bool
    {
        return $this->validationErrors !== null;
    }

    public function getValidationErrors(): array
    {
        return $this->validationErrors ?? [];
    }
}
