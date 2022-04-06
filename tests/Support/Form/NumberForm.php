<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;

final class NumberForm extends FormModel
{
    public ?int $age = 42;

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
