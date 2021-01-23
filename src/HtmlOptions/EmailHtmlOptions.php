<?php

declare(strict_types=1);

namespace Yiisoft\Form\HtmlOptions;

use Yiisoft\Validator\Rule\Email;

final class EmailHtmlOptions implements HtmlOptionsProvider
{
    private Email $validator;

    public function __construct(Email $validator)
    {
        $this->validator = $validator;
    }

    public function getHtmlOptions(): array
    {
        return [
            'type' => 'email',
        ];
    }
}
