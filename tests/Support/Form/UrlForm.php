<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\Regex;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\Url;

final class UrlForm extends FormModel
{
    public string $site = '';
    public string $company = '';
    public string $home = '';
    public string $code = '';
    public string $nocode = '';
    public string $shop = '';
    public string $beach = '';
    public string $beach2 = '';
    public ?string $post = null;
    public int $age = 42;
    public ?int $requiredWhen = null;

    public function getAttributeLabels(): array
    {
        return [
            'site' => 'Your site',
        ];
    }

    public function getRules(): array
    {
        return [
            'company' => [new Required()],
            'home' => [new HasLength(min: 50, max: 199)],
            'code' => [new Regex(pattern: '~\w+~')],
            'nocode' => [new Regex(pattern: '~\w+~', not: true)],
            'shop' => [new Url()],
            'beach' => [new Url(), new Regex(pattern: '~\w+~')],
            'beach2' => [new Regex(pattern: '~\w+~'), new Url()],
            'requiredWhen' => [new Required(when: static fn() => false)],
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'site' => 'Enter your site URL.',
        ];
    }
}
