<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\YiiValidator\FormModel;

final class CheckboxListForm extends FormModel
{
    public array $color = [];
    public int $age = 42;

    public function getAttributeLabels(): array
    {
        return [
            'color' => 'Select one or more colors',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'color' => 'Color of box.',
        ];
    }
}
