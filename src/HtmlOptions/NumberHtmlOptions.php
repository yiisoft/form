<?php
declare(strict_types=1);

namespace Yiisoft\Form\HtmlOptions;

use Yiisoft\Validator\Rule\Number;

class NumberHtmlOptions implements HtmlOptionsProvider
{
    private Number $validator;

    public function __construct(Number $validator)
    {
        $this->validator = $validator;
    }

    public function getHtmlOptions(): array
    {
        $options = $this->validator->getOptions();
        return [
            'min' => $options['min'],
            'max' => $options['max'],
        ];
    }
}
