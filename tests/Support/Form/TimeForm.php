<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;

final class TimeForm extends FormModel
{
    private string $checkinTime = '15:00';
    private string $startTime = '16:00';

    public function getAttributeLabels(): array
    {
        return [
            'checkinTime' => 'Check-in Time',
            'startTime' => 'StartTime',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'checkinTime' => 'Check-in Time.',
        ];
    }
}
