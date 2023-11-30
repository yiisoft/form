<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\YiisoftFormModel\FormModel;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\RulesProviderInterface;

final class DateForm extends FormModel implements RulesProviderInterface
{
    private string $birthday = '1996-12-19';
    private ?string $startDate = null;
    private ?string $endDate = null;
    private ?string $main = null;
    private ?string $second = null;
    private int $age = 42;

    public function getRules(): array
    {
        return [
            'main' => [new Required()],
            'second' => [new Required(when: static fn () => false)],
        ];
    }

    public function getAttributeLabels(): array
    {
        return [
            'birthday' => 'Your birthday',
            'startDate' => 'Date of start',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'birthday' => 'Birthday date.',
        ];
    }
}
