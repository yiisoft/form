<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base\InputData;

use Yiisoft\Form\ValidationRulesEnricherInterface;

/**
 * Represents some common information about input and its validation rules / state.
 */
interface InputDataInterface
{
    /**
     * Unique name of an input within the form (not visible to the end user).
     *
     * @return string|null Name of the input or null if missing.
     */
    public function getName(): ?string;

    /**
     * Filled value that is about to be sent to the server.
     *
     * @return mixed Value of the input.
     */
    public function getValue(): mixed;

    /**
     * The label associated with this field (visible to the end user).
     *
     * @return string|null Input label or null if missing.
     */
    public function getLabel(): ?string;

    /**
     * Complimentary text explaining certain details regarding this input.
     *
     * @return string|null Input hint or null if missing.
     */
    public function getHint(): ?string;

    /**
     * The prefilled value, used as a default or an example.
     *
     * @return string|null Input placeholder or null if no placeholder is used.
     */
    public function getPlaceholder(): ?string;

    /**
     * @return string|null ID of the input or null if missing.
     */
    public function getId(): ?string;

    /**
     * Validation state (whether the input has been already validated).
     *
     * @return bool Whether input was validated.
     */
    public function isValidated(): bool;

    /**
     * Validation rules in any format. They are intended to be processed by
     * {@see ValidationRulesEnricherInterface::process()}.
     *
     * @return mixed Input validation rules.
     */
    public function getValidationRules(): mixed;

    /**
     * The list of validation errors for this attribute.
     *
     * @return string[] Input validation errors.
     * @psalm-return list<string>
     */
    public function getValidationErrors(): array;
}
