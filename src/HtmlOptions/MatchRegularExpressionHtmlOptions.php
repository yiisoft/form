<?php

declare(strict_types=1);

namespace Yiisoft\Form\HtmlOptions;

use Yiisoft\Html\Html;
use Yiisoft\Validator\Rule\MatchRegularExpression;
use Yiisoft\Validator\RuleInterface;

final class MatchRegularExpressionHtmlOptions implements HtmlOptionsProvider, RuleInterface
{
    use RuleAwareTrait;

    public function __construct(MatchRegularExpression $rule)
    {
        $this->rule = $rule;
    }

    public function getHtmlOptions(): array
    {
        $options = $this->rule->getOptions();
        return [
            'pattern' => Html::normalizeRegexpPattern($options['pattern']),
        ];
    }
}
