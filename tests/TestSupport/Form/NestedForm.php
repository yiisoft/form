<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\Number;

final class NestedForm extends FormModel
{
    private ?string $id = null;
    private ?int $number = null;

    public function getRules(): array
    {
        return [
            'id' => [Required::rule()],
            'number' => [Number::rule()->integer()->min(1)],
        ];
    }
}
