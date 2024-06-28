<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support;

use Yiisoft\Form\Field\Base\BaseField;
use Yiisoft\Form\ValidationRulesEnricherInterface;

final class RequiredValidationRulesEnricher implements ValidationRulesEnricherInterface
{
    public function process(BaseField $field, mixed $rules): ?array
    {
        $enrichment = [];
        /** @var array $rules */
        foreach ($rules as $rule) {
            if ($rule[0] === 'required') {
                $enrichment['inputAttributes']['required'] = true;
            }
        }

        return $enrichment;
    }
}
