<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base\EnrichFromValidationRules;

use Yiisoft\Form\ValidationRulesEnricherInterface;

/**
 * Controls whether a field's configuration should be enriched by additional configuration / parameters provided by
 * {@see ValidationRulesEnricherInterface::process()}.
 */
interface EnrichFromValidationRulesInterface
{
    /**
     * Enable/disable enrichment based on validation rules.
     */
    public function enrichFromValidationRules(bool $enrich): self;

    public function validationRulesEnricher(?ValidationRulesEnricherInterface $enricher): self;
}
