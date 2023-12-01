<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\YiisoftFormModel\FormModel;

final class LabelForm extends FormModel
{
    private ?string $name = null;

    public function getPropertyLabels(): array
    {
        return [
            'name' => 'Name',
        ];
    }
}
