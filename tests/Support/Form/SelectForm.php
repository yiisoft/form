<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;

final class SelectForm extends FormModel
{
    public ?int $number = null;
    public int $count = 15;
    public array $letters = ['A', 'C'];

    public function getAttributeLabels(): array
    {
        return [
            'number' => 'Select number',
            'count' => 'Select count',
            'letters' => 'Select letters',
        ];
    }
}
