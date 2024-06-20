<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base\EnrichFromValidationRules;

/**
 * Allows to add extra input attributes configuration based on validation rules.
 */
interface EnrichFromValidationRulesInterface
{
    /**
     * Enable/disable extra input attributes configuration based on validation rules.
     */
    public function enrichFromValidationRules(bool $enrich): self;
}
