<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;

final class PasswordForm extends FormModel
{
    public string $old = '';

    public function getAttributeLabels(): array
    {
        return [
            'old' => 'Old password',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'old' => 'Enter your old password.',
        ];
    }
}
