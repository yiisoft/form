<?php

declare(strict_types=1);

namespace Yiisoft\Form\HtmlOptions;

use Yiisoft\Validator\DataSetInterface;
use Yiisoft\Validator\ParametrizedRuleInterface;
use Yiisoft\Validator\Result;

trait RuleAwareTrait
{
    protected ParametrizedRuleInterface $rule;

    public function validate($value, DataSetInterface $dataSet = null, bool $previousRulesErrored = false): Result
    {
        return $this->rule->validate($value, $dataSet, $previousRulesErrored);
    }
}
