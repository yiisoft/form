<?php

declare(strict_types=1);

namespace Yiisoft\Form;

interface FormInterface
{
    public function addError(string $attribute, string $error): void;
    public function addErrors(array $items): void;
    public function attributesLabels(): array;
    public function clearErrors(?string $attribute = null): void;
    public function getAttributes(): array;
    public function getAttributeHint(string $attribute): string;
    public function getAttributesHints(): array;
    public function getAttributeLabel(string $attribute): string;
    public function getAttributesLabels(): array;
    public function getError(string $attribute): ?array;
    public function getErrors(): ?array;
    public function getFirstError(string $attribute): ?string;
    public function getFirstErrors(): array;
    public function getFormname(): string;
    public function hasErrors(?string $attribute = null): bool;
    public function load(array $data): bool;
}
