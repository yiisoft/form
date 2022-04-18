<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;

final class RadioListForm extends FormModel
{
    public ?string $color = null;

    public function getAttributeLabels(): array
    {
        return [
            'color' => 'Select color',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'color' => 'Color of box.',
        ];
    }
}
