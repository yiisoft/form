<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;

final class TextareaForm extends FormModel
{
    public string $desc = '';

    public function getAttributeLabels(): array
    {
        return [
            'desc' => 'Description',
        ];
    }
}
