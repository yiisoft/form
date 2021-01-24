<?php

declare(strict_types=1);

namespace Yiisoft\Form\HtmlOptions;

use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\RuleInterface;

final class HasLengthHtmlOptions implements HtmlOptionsProvider, RuleInterface
{
    use RuleAwareTrait;

    public function __construct(HasLength $rule)
    {
        $this->rule = $rule;
    }

    public function getHtmlOptions(): array
    {
        $options = $this->rule->getOptions();
        return [
            'minlength' => $options['min'],
            'maxlength' => $options['max'],
        ];
    }
}
