<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\YiisoftFormModel\FormModel;
use Yiisoft\Validator\Rule\Integer;
use Yiisoft\Validator\Rule\Length;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\RulesProviderInterface;

final class ErrorForm extends FormModel implements RulesProviderInterface
{
    private string $name = '';
    private int $age = 42;

    public function getAttributeLabels(): array
    {
        return [
            'name' => 'Name',
            'age' => 'Age',
        ];
    }

    public function getRules(): array
    {
        return [
            'name' => [new Required(), new Length(min: 4)],
            'age' => [new Integer(min: 18)],
        ];
    }
}
