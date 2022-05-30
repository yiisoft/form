<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base\EnrichmentFromRules;

trait EnrichmentFromRulesTrait
{
    private bool $enrichmentFromRules = false;

    public function enrichmentFromRules(bool $enrichment): self
    {
        $new = clone $this;
        $new->enrichmentFromRules = $enrichment;
        return $new;
    }
}
