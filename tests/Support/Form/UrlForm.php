<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;

final class UrlForm extends FormModel
{
    public string $site = '';

    public function getAttributeLabels(): array
    {
        return [
            'site' => 'Your site',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'site' => 'Enter your site URL.',
        ];
    }
}
