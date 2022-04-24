<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\Rule\Callback;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Validator;

final class ErrorSummaryForm extends FormModel
{
    public string $name = '';
    public int $age = 42;
    public int $year = 999;

    public function getRules(): array
    {
        return [
            'name' => [new Required()],
            'age' => [
                new Callback(
                    static fn() => (new Result())->addError('<b>Very</b> old.')
                ),
            ],
            'year' => [
                new Callback(
                    static fn() => (new Result())->addError('Bad year.')
                ),
                new Callback(
                    static fn() => (new Result())->addError('Very Bad year.')
                ),
            ]
        ];
    }

    public function getAttributeLabels(): array
    {
        return [
            'name' => 'Your name',
        ];
    }

    public static function validated(): self
    {
        $form = new self();
        (new Validator())->validate($form);
        return $form;
    }
}
