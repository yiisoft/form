<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\YiisoftYiiValidatableForm\FormModel;
use Yiisoft\Validator\Rule\Number;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\RulesProviderInterface;

final class RangeForm extends FormModel implements RulesProviderInterface
{
    private int $volume = 23;
    private ?int $count = null;
    private bool $flag = true;
    public ?int $requiredWhen = null;

    public function getRules(): array
    {
        return [
            'volume' => [new Required()],
            'count' => [new Number(min: 1, max: 9)],
            'requiredWhen' => [new Required(when: static fn () => false)],
        ];
    }

    public function getAttributeLabels(): array
    {
        return [
            'volume' => 'Volume level',
        ];
    }
}
