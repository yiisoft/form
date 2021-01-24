<?php

declare(strict_types=1);

namespace Yiisoft\Form\HtmlOptions;

use Yiisoft\Html\Html;
use Yiisoft\Validator\Rule\MatchRegularExpression;
use Yiisoft\Validator\RuleInterface;

final class MatchRegularExpressionHtmlOptions implements HtmlOptionsProvider, RuleInterface
{
    use ValidatorAwareTrait;

    public function __construct(MatchRegularExpression $validator)
    {
        $this->validator = $validator;
    }

    public function getHtmlOptions(): array
    {
        $options = $this->validator->getOptions();
        return [
            'pattern' => Html::normalizeRegexpPattern($options['pattern']),
        ];
    }
}
