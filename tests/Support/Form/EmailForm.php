<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;

final class EmailForm extends FormModel
{
    public string $main = '';
    public function getAttributeLabels(): array
    {
        return [
            'main' => 'Main email',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'main' => 'Email for notifications.',
        ];
    }
}
