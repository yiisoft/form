<?php

declare(strict_types=1);

namespace Yiisoft\Form\HtmlOptions;

use Yiisoft\Validator\Rule\Number;
use Yiisoft\Validator\RuleInterface;

final class NumberHtmlOptions implements HtmlOptionsProvider, RuleInterface
{
    use RuleAwareTrait;

    public function __construct(Number $rule)
    {
        $this->rule = $rule;
    }

    public function getHtmlOptions(): array
    {
        $options = $this->rule->getOptions();
        return [
            'type' => 'number',
            'min' => $options['min'],
            'max' => $options['max'],
        ];
    }
}
