<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use Yiisoft\Validator\Validator;
use Yiisoft\Validator\ValidatorFactoryInterface;
use Yiisoft\Validator\ValidatorInterface;

final class ValidatorFactoryMock implements ValidatorFactoryInterface
{
    public function create(array $rules): ValidatorInterface
    {
        return new Validator($rules);
    }
}
