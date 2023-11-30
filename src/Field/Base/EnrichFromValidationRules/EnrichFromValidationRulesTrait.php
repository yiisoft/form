<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base\EnrichFromValidationRules;

trait EnrichFromValidationRulesTrait
{
    private bool $enrichFromValidationRules = false;

    public function enrichFromValidationRules(bool $enrich): self
    {
        $new = clone $this;
        $new->enrichFromValidationRules = $enrich;
        return $new;
    }
}
