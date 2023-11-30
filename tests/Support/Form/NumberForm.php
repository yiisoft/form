<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\YiiValidator\FormModel;
use Yiisoft\Validator\Rule\Number;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\RulesProviderInterface;

final class NumberForm extends FormModel implements RulesProviderInterface
{
    public ?int $age = 42;
    public ?int $count = null;
    public string $name = 'Mike';
    public ?int $weight = null;
    public ?int $step = null;
    public ?int $requiredWhen = null;

    public function getRules(): array
    {
        return [
            'weight' => [new Required()],
            'step' => [new Number(min: 5, max: 95)],
            'requiredWhen' => [new Required(when: static fn () => false)],
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
