<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\YiisoftFormModel\FormModel;

final class FieldsetForm extends FormModel
{
    public string $firstName = '';
    public string $lastName = '';

    public function getPropertyLabels(): array
    {
        return [
            'firstName' => 'First name',
            'lastName' => 'Last name',
        ];
    }
}
