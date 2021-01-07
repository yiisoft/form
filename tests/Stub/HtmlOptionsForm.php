<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Stub;

use Yiisoft\Form\FormModel;
use Yiisoft\Form\HtmlOptions\NumberHtmlOptions;
use Yiisoft\Form\Tests\ValidatorFactoryMock;
use Yiisoft\Validator\Rule\Number;

final class HtmlOptionsForm extends FormModel
{
    private string $name = '';

    public function __construct()
    {
        parent::__construct(new ValidatorFactoryMock());
    }

    public function rules(): array
    {
        return [
            'name' => [
                new NumberHtmlOptions(
                    (new Number())
                        ->min(4)->tooSmallMessage('Is too small.')
                        ->max(5)->tooBigMessage('Is too big.')
                ),
            ],
        ];
    }
}
