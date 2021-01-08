<?php

declare(strict_types=1);

namespace Yiisoft\Form\HtmlOptions;

use Yiisoft\Validator\DataSetInterface;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\ValidatorRuleInterface;

trait ValidatorAwareTrait
{
    private ValidatorRuleInterface $validator;

    public function validate($value, DataSetInterface $dataSet = null, bool $previousRulesErrored = false): Result
    {
        return $this->validator->validate($value, $dataSet, $previousRulesErrored);
    }
}
