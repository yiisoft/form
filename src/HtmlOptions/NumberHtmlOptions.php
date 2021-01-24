<?php

declare(strict_types=1);

namespace Yiisoft\Form\HtmlOptions;

use Yiisoft\Validator\Rule\Number;
use Yiisoft\Validator\RuleInterface;

final class NumberHtmlOptions implements HtmlOptionsProvider, RuleInterface
{
    use ValidatorAwareTrait;

    public function __construct(Number $validator)
    {
        $this->validator = $validator;
    }

    public function getHtmlOptions(): array
    {
        $options = $this->validator->getOptions();
        return [
            'type' => 'number',
            'min' => $options['min'],
            'max' => $options['max'],
        ];
    }
}
