<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\HasLength\HasLength;
use Yiisoft\Validator\Rule\Number\Number;
use Yiisoft\Validator\Rule\Regex\Regex;
use Yiisoft\Validator\Rule\Required\Required;
use Yiisoft\Validator\Rule\Url\Url;

final class ValidatorForm extends FormModel
{
    private ?string $login = '';
    private ?string $password = '';
    private int $number = 0;
    private int $numberRequired = 0;
    private string $regex = '';
    private string $maxlength = '';
    private string $minlength = '';
    private string $required = '';
    private string $url = '';
    private string $urlWithPattern = '';

    public function getRules(): array
    {
        return [
            'regex' => [new Regex('/\w+/')],
            'maxlength' => [new HasLength(max: 50)],
            'minlength' => [new HasLength(min: 15)],
            'number' => [new Number(min: 3, max: 5)],
            'numberRequired' => [new Required()],
            'required' => [new Required()],
            'url' => [new Url()],
            'urlWithPattern' => [new Url(
                validSchemes: ['Http', 'Https'],
            )],
        ];
    }
}
