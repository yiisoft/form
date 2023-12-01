<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\YiisoftFormModel\FormModel;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\Rule\Callback;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\RulesProviderInterface;
use Yiisoft\Validator\Validator;

final class ErrorSummaryForm extends FormModel implements RulesProviderInterface
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
                    static fn () => (new Result())->addError('<b>Very</b> old.')
                ),
            ],
            'year' => [
                new Callback(
                    static fn () => (new Result())->addError('Bad year.')
                ),
                new Callback(
                    static fn () => (new Result())->addError('Very Bad year.')
                ),
            ],
        ];
    }

    public function getPropertyLabels(): array
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
