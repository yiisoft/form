<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;

final class TelephoneForm extends FormModel
{
    public string $number = '';

    public function getAttributeLabels(): array
    {
        return [
            'number' => 'Phone',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'number' => 'Enter your phone.',
        ];
    }
}
