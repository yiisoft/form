<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;

final class DateForm extends FormModel
{
    private string $birthday = '1996-12-19';
    private ?string $startDate = null;

    public function getAttributeLabels(): array
    {
        return [
            'birthday' => 'Your birthday',
            'startDate' => 'Date of start',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'birthday' => 'Birthday date.',
        ];
    }
}
