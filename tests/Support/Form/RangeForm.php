<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Number;
use Yiisoft\Validator\Rule\Required;

final class RangeForm extends FormModel
{
    private int $volume = 23;
    private ?int $count = null;
    private bool $flag = true;

    public function getRules(): array
    {
        return [
            'volume' => [new Required()],
            'count' => [new Number(min: 1, max: 9)],
        ];
    }

    public function getAttributeLabels(): array
    {
        return [
            'volume' => 'Volume level',
        ];
    }
}
