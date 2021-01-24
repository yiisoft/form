<?php

declare(strict_types=1);

namespace Yiisoft\Form\HtmlOptions;

use Yiisoft\Validator\Rule\Email;
use Yiisoft\Validator\RuleInterface;

final class EmailHtmlOptions implements HtmlOptionsProvider, RuleInterface
{
    use RuleAwareTrait;

    public function __construct(Email $rule)
    {
        $this->rule = $rule;
    }

    public function getHtmlOptions(): array
    {
        return [
            'type' => 'email',
        ];
    }
}
