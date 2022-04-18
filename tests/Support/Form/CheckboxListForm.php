<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;

final class CheckboxListForm extends FormModel
{
    public ?string $color = null;

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
