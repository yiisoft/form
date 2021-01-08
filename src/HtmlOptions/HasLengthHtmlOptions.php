<?php

declare(strict_types=1);

namespace Yiisoft\Form\HtmlOptions;

use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\ValidatorRuleInterface;

class HasLengthHtmlOptions implements HtmlOptionsProvider, ValidatorRuleInterface
{
    use ValidatorAwareTrait;

    public function __construct(HasLength $validator)
    {
        $this->validator = $validator;
    }

    public function getHtmlOptions(): array
    {
        $options = $this->validator->getOptions();
        return [
            'minlength' => $options['min'],
            'maxlength' => $options['max'],
        ];
    }
}
