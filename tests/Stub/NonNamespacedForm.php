<?php

declare(strict_types=1);

use Yiisoft\Form\FormModel;
use Yiisoft\Form\Tests\ValidatorFactoryMock;

class NonNamespacedForm extends FormModel
{
    public function __construct()
    {
        parent::__construct(new ValidatorFactoryMock());
    }
}
