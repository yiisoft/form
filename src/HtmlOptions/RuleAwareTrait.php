<?php

declare(strict_types=1);

namespace Yiisoft\Form\HtmlOptions;

use Yiisoft\Validator\ParametrizedRuleInterface;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\ValidationContext;

trait RuleAwareTrait
{
    protected ParametrizedRuleInterface $rule;

    /**
     * @param mixed $value
     */
    public function validate($value, ValidationContext $context = null): Result
    {
        return $this->rule->validate($value, $context);
    }
}
