<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\YiisoftYiiValidatableForm\FormModel;

final class HintForm extends FormModel
{
    private ?string $name = null;
    private ?int $age = null;

    public function getAttributeHints(): array
    {
        return [
            'name' => 'Write your name.',
        ];
    }
}
