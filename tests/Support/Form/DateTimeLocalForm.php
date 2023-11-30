<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\YiisoftYiiValidatableForm\FormModel;

final class DateTimeLocalForm extends FormModel
{
    private string $partyDate = '2017-06-01T08:30';

    public function getAttributeLabels(): array
    {
        return [
            'partyDate' => 'Date of party',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'partyDate' => 'Party date.',
        ];
    }
}
