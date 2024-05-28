<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base\InputData;

/**
 * Represents input data.
 */
interface InputDataInterface
{
    /**
     * @return string|null Name of the input or null if ???
     */
    public function getName(): ?string;

    /**
     * @return mixed Value of the input.
     */
    public function getValue(): mixed;

    /**
     * @return string|null Input label or null if ???
     */
    public function getLabel(): ?string;

    public function getHint(): ?string;

    /**
     * @return string|null Input placeholder or null if no placeholder is used.
     */
    public function getPlaceholder(): ?string;

    /**
     * @return string|null ID of the input or null if ???
     */
    public function getId(): ?string;

    /**
     * @return bool Whether input was validated.
     */
    public function isValidated(): bool;

    /**
     * @return mixed Input validation rules.
     */
    public function getValidationRules(): mixed;

    /**
     * @return string[] Input validation errors.
     * @psalm-return list<string>
     */
    public function getValidationErrors(): array;
}
