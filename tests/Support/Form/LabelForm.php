<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\YiisoftYiiValidatableForm\FormModel;

final class LabelForm extends FormModel
{
    private ?string $name = null;

    public function getAttributeLabels(): array
    {
        return [
            'name' => 'Name',
        ];
    }
}
