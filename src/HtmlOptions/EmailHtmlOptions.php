<?php

declare(strict_types=1);

namespace Yiisoft\Form\HtmlOptions;

use Yiisoft\Validator\Rule\Email;
use Yiisoft\Validator\ValidatorRuleInterface;

class EmailHtmlOptions implements HtmlOptionsProvider, ValidatorRuleInterface
{
    use ValidatorAwareTrait;

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
