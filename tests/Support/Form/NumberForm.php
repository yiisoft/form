<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Number;
use Yiisoft\Validator\Rule\Required;

final class NumberForm extends FormModel
{
    public ?int $age = 42;
    public ?int $count = null;
    public string $name = 'Mike';
    public ?int $weight = null;
    public ?int $step = null;

    public function getRules(): array
    {
        return [
            'weight' => [new Required()],
            'step' => [new Number(min: 5, max: 95)],
        ];
    }

    public function getAttributeLabels(): array
    {
        return [
            'age' => 'Your age',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'age' => 'Full years.',
        ];
    }
}
