<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Required;

final class FileForm extends FormModel
{
    private ?string $avatar = null;
    private ?string $image = null;
    private ?int $age = 42;

    public function getRules(): array
    {
        return [
            'image' => [new Required()],
        ];
    }

    public function getAttributeLabels(): array
    {
        return [
            'avatar' => 'Avatar',
        ];
    }
}
