<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base\InputData;

final class PureInputData implements InputDataInterface
{
    public function __construct(
        private ?string $name = null,
        private mixed $value = null,
    ) {
    }

    public function getValidationRules(): array
    {
        return [];
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
        return null;
    }

    public function getHint(): ?string
    {
        return null;
    }

    public function getPlaceholder(): ?string
    {
        return null;
    }

    public function getId(): ?string
    {
        return null;
    }

    public function isValidated(): bool
    {
        return false;
    }

    public function getValidationErrors(): array
    {
        return [];
    }

    public function withName(?string $name): static
    {
        $new = clone $this;
        $new->name = $name;
        return $new;
    }

    public function withValue(mixed $value): static
    {
        $new = clone $this;
        $new->value = $value;
        return $new;
    }
}
