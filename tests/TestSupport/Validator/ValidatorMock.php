<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Validator;

use Yiisoft\Validator\Result;
use Yiisoft\Validator\SimpleRuleHandlerContainer;
use Yiisoft\Validator\Validator;
use Yiisoft\Validator\ValidatorInterface;

final class ValidatorMock implements ValidatorInterface
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator(new SimpleRuleHandlerContainer());
    }

    public function validate($data, ?iterable $rules = null): Result
    {
        return $this->validator->validate($data, $rules);
    }
}
