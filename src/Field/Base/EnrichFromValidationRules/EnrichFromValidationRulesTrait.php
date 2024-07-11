<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base\EnrichFromValidationRules;

use Yiisoft\Form\ValidationRulesEnricherInterface;

trait EnrichFromValidationRulesTrait
{
    private bool $enrichFromValidationRules = false;
    private ?ValidationRulesEnricherInterface $validationRulesEnricher = null;

    public function enrichFromValidationRules(bool $enrich = true): self
    {
        $new = clone $this;
        $new->enrichFromValidationRules = $enrich;
        return $new;
    }

    public function validationRulesEnricher(?ValidationRulesEnricherInterface $enricher): self
    {
        $new = clone $this;
        $new->validationRulesEnricher = $enricher;
        return $new;
    }
}
