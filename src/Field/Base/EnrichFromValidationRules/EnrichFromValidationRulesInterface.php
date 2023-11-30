<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base\EnrichFromValidationRules;

/**
 * Fields implementing `EnrichFromValidationRulesInterface` can automatically configuration based on validation rules.
 */
interface EnrichFromValidationRulesInterface
{
    /**
     * Enable/disable automatic configuration based on validation rules.
     */
    public function enrichFromValidationRules(bool $enrich): self;
}
