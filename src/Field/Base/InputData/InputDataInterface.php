<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base\InputData;

interface InputDataInterface
{
    public function getName(): ?string;

    public function getValue(): mixed;

    public function getLabel(): ?string;

    public function getHint(): ?string;

    public function getPlaceholder(): ?string;

    public function getId(): ?string;

    public function isValidated(): bool;

    public function getValidationRules(): mixed;

    /**
     * @return string[]
     * @psalm-return list<string>
     */
    public function getValidationErrors(): array;
}
