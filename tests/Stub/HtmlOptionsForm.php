<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Stub;

use Yiisoft\Form\FormModel;
use Yiisoft\Form\HtmlOptions\EmailHtmlOptions;
use Yiisoft\Form\HtmlOptions\HasLengthHtmlOptions;
use Yiisoft\Form\HtmlOptions\MatchRegularExpressionHtmlOptions;
use Yiisoft\Form\HtmlOptions\NumberHtmlOptions;
use Yiisoft\Form\HtmlOptions\RequiredHtmlOptions;
use Yiisoft\Validator\Rule\Email;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\MatchRegularExpression;
use Yiisoft\Validator\Rule\Number;
use Yiisoft\Validator\Rule\Required;

final class HtmlOptionsForm extends FormModel
{
    private string $number = '';
    private string $hasLength = '';
    private string $required = '';
    private string $pattern = '';
    private string $email = '';
    private string $combined = '';

    public function getRules(): array
    {
        return [
            'number' => [
                $this->getNumberHtmlOptions(),
            ],
            'hasLength' => [
                $this->getHasLengthHtmlOptions(),
            ],
            'required' => [
                $this->getRequiredHtmlOptions(),
            ],
            'pattern' => [
                $this->getMatchRegularExpressionHtmlOptions(),
            ],
            'email' => [
                $this->getEmailHtmlOptions(),
            ],
            'combined' => [
                $this->getNumberHtmlOptions(),
                $this->getHasLengthHtmlOptions(),
                $this->getRequiredHtmlOptions(),
                $this->getMatchRegularExpressionHtmlOptions(),
            ],
        ];
    }

    private function getMatchRegularExpressionHtmlOptions(): MatchRegularExpressionHtmlOptions
    {
        return new MatchRegularExpressionHtmlOptions(
            MatchRegularExpression::rule('/\w+/')
        );
    }

    private function getEmailHtmlOptions(): EmailHtmlOptions
    {
        return new EmailHtmlOptions(
            Email::rule()
        );
    }

    private function getRequiredHtmlOptions(): RequiredHtmlOptions
    {
        return new RequiredHtmlOptions(
            Required::rule()
        );
    }

    private function getHasLengthHtmlOptions(): HasLengthHtmlOptions
    {
        return new HasLengthHtmlOptions(
            HasLength::rule()
                ->min(4)->tooShortMessage('Is too short.')
                ->max(5)->tooLongMessage('Is too long.')
        );
    }

    private function getNumberHtmlOptions(): NumberHtmlOptions
    {
        return new NumberHtmlOptions(
            Number::rule()
                ->min(4)->tooSmallMessage('Is too small.')
                ->max(5)->tooBigMessage('Is too big.')
        );
    }
}
