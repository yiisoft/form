<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base\EnrichmentFromRules;

interface EnrichmentFromRulesInterface
{
    public function enrichmentFromRules(bool $enrichment): self;
}
