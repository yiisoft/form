<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\YiisoftFormModel\FormModel;

final class DateTimeLocalForm extends FormModel
{
    private string $partyDate = '2017-06-01T08:30';

    public function getPropertyLabels(): array
    {
        return [
            'partyDate' => 'Date of party',
        ];
    }

    public function getPropertyHints(): array
    {
        return [
            'partyDate' => 'Party date.',
        ];
    }
}
