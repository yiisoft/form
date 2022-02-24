<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\MatchRegularExpression;
use Yiisoft\Validator\Rule\Number;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\Url;

final class ValidatorForm extends FormModel
{
    private ?string $login = '';
    private ?string $password = '';
    private int $number = 0;
    private int $numberRequired = 0;
    private string $matchregular = '';
    private string $maxlength = '';
    private string $minlength = '';
    private string $required = '';
    private string $url = '';

    public function getRules(): array
    {
        return [
            'matchregular' => [new MatchRegularExpression('/\w+/')],
            'maxlength' => [new HasLength(max: 50)],
            'minlength' => [new HasLength(min: 15)],
            'number' => [new Number(min: 3, max: 5)],
            'numberRequired' => [new Required()],
            'required' => [new Required()],
            'url' => [new Url()],
        ];
    }
}
