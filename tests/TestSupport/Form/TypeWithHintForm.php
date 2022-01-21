<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;

final class TypeWithHintForm extends FormModel
{
    private ?string $login = '';
    private ?string $password = '';

    public function getAttributeHints(): array
    {
        return [
            'login' => 'Please enter your login.',
            'password' => 'Please enter your password.',
        ];
    }
}
