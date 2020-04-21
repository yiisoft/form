<?php

declare(strict_types=1);

namespace Yiisoft\Form;

use Yiisoft\Validator\DataSetInterface;

interface FormInterface extends DataSetInterface
{
    public function addError(string $attribute, string $error): void;
    public function addErrors(array $items): void;
    public function attributeLabels(): array;
    public function clearErrors(?string $attribute = null): void;
    public function isAttributeRequired(string $attribute): bool;
    public function getAttributes(): array;
    public function getAttributeHint(string $attribute): string;
    public function getAttributeHints(): array;
    public function getAttributeLabel(string $attribute): string;
    public function getError(string $attribute): ?array;
    public function getErrors(): ?array;
    public function getErrorSummary(bool $showAllErrors): array;
    public function getFirstError(string $attribute): ?string;
    public function getFirstErrors(): array;
    public function formName(): string;
    public function hasErrors(?string $attribute = null): bool;
    public function load(array $data): bool;
}
