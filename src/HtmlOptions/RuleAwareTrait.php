<?php

declare(strict_types=1);

namespace Yiisoft\Form\HtmlOptions;

use Yiisoft\Validator\DataSetInterface;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleInterface;

trait RuleAwareTrait
{
    private RuleInterface $rule;

    public function validate($value, DataSetInterface $dataSet = null, bool $previousRulesErrored = false): Result
    {
        return $this->rule->validate($value, $dataSet, $previousRulesErrored);
    }
}
