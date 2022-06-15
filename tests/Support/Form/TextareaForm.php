<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\Required;

final class TextareaForm extends FormModel
{
    private string $desc = '';
    private string $bio = '';
    private string $shortdesc = '';
    private int $age = 42;
    public ?int $requiredWhen = null;

    public function getRules(): array
    {
        return [
            'bio' => [new Required()],
            'shortdesc' => [new HasLength(min: 10, max: 199)],
            'requiredWhen' => [new Required(when: static fn() => false)],
        ];
    }

    public function getAttributeLabels(): array
    {
        return [
            'desc' => 'Description',
        ];
    }
}
