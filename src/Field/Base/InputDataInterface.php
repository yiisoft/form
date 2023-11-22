<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use Yiisoft\Validator\Helper\RulesNormalizer;
use Yiisoft\Validator\Result;

/**
 * @psalm-import-type NormalizedRulesList from RulesNormalizer
 */
interface InputDataInterface
{
    public function getName(): ?string;

    public function getValue(): mixed;

    public function getLabel(): ?string;

    public function getHint(): ?string;

    public function getPlaceholder(): ?string;

    public function getId(): ?string;

    public function isValidated(): bool;

    /**
     * @psalm-return NormalizedRulesList
     */
    public function getValidationRules(): iterable;

    /**
     * @return string[]
     * @psalm-return list<string>
     */
    public function getValidationErrors(): array;
}
