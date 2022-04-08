<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;

final class RangeForm extends FormModel
{
    public int $volume = 23;

    public function getAttributeLabels(): array
    {
        return [
            'volume' => 'Volume level',
        ];
    }
}
