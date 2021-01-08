<?php

declare(strict_types=1);

namespace Yiisoft\Form\HtmlOptions;

use Yiisoft\Validator\Rule\Required;

class RequiredHtmlOptions implements HtmlOptionsProvider
{
    private Required $validator;

    public function __construct(Required $validator)
    {
        $this->validator = $validator;
    }

    public function getHtmlOptions(): array
    {
        return [
            'required' => true,
        ];
    }
}
