<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\Number;
use Yiisoft\Validator\Rule\Required;

final class ErrorForm extends FormModel
{
    private string $name = '';
    private int $age = 42;

    public function getAttributeLabels(): array
    {
        return [
            'name' => 'Name',
            'age' => 'Age',
        ];
    }

    public function getRules(): array
    {
        return [
            'name' => [Required::rule(), HasLength::rule()->min(4)],
            'age' => [Number::rule()->integer()->min(18)],
        ];
    }
}
