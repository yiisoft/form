<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base\EnrichmentFromRules;

/**
 * Fields implementing `EnrichmentFromRulesInterface` can automatically configuration based on validation rules.
 */
interface EnrichmentFromRulesInterface
{
    /**
     * Enable/disable automatic configuration based on validation rules.
     */
    public function enrichmentFromRules(bool $enrichment): self;
}
