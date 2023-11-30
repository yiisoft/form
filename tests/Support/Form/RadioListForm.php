<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\YiisoftYiiValidatableForm\FormModel;

final class RadioListForm extends FormModel
{
    private ?string $color = null;
    private ?int $number = null;
    private array $data = [];

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
