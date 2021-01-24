<?php

declare(strict_types=1);

namespace Yiisoft\Form\HtmlOptions;

use Yiisoft\Validator\Rule\Email;
use Yiisoft\Validator\RuleInterface;

final class EmailHtmlOptions implements HtmlOptionsProvider, RuleInterface
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
