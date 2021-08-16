<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Form\HtmlOptions\HasLengthHtmlOptions;
use Yiisoft\Form\HtmlOptions\MatchRegularExpressionHtmlOptions;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\MatchRegularExpression;
use Yiisoft\Validator\Rule\Number;

final class AttributesValidatorForm extends FormModel
{
    private string $number = '';
    private string $hasLength = '';
    private string $required = '';
    private string $pattern = '';
    private string $combined = '';

    public function getRules(): array
    {
        return [
            'number' => [
                Number::rule()->min(3)->tooSmallMessage('Is too small.')->max(5)->tooBigMessage('Is too big.'),
            ],
            'hasLength' => [
                $this->getHasLengthHtmlOptions(),
            ],
            'pattern' => [
                $this->getMatchRegularExpressionHtmlOptions(),
            ],
        ];
    }

    private function getMatchRegularExpressionHtmlOptions(): MatchRegularExpressionHtmlOptions
    {
        return new MatchRegularExpressionHtmlOptions(MatchRegularExpression::rule('/\w+/'));
    }

    private function getHasLengthHtmlOptions(): HasLengthHtmlOptions
    {
        return new HasLengthHtmlOptions(
            HasLength::rule()->min(3)->tooShortMessage('Is too short.')->max(5)->tooLongMessage('Is too long.')
        );
    }
}
