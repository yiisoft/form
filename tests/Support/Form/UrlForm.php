<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\YiisoftFormModel\FormModel;
use Yiisoft\Validator\Rule\Length;
use Yiisoft\Validator\Rule\Regex;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\Url;
use Yiisoft\Validator\RulesProviderInterface;

final class UrlForm extends FormModel implements RulesProviderInterface
{
    public string $site = '';
    public string $company = '';
    public string $home = '';
    public string $code = '';
    public string $nocode = '';
    public string $shop = '';
    public string $beach = '';
    public string $beach2 = '';
    public string $urlWithIdn = '';
    public string $regexAndUrlWithIdn = '';
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
            'home' => [new Length(min: 50, max: 199)],
            'code' => [new Regex(pattern: '~\w+~')],
            'nocode' => [new Regex(pattern: '~\w+~', not: true)],
            'shop' => [new Url()],
            'beach' => [new Url(), new Regex(pattern: '~\w+~')],
            'beach2' => [new Regex(pattern: '~\w+~'), new Url()],
            'requiredWhen' => [new Required(when: static fn () => false)],
            'urlWithIdn' => [new Url(enableIdn: true)],
            'regexAndUrlWithIdn' => [new Url(enableIdn: true), new Regex(pattern: '~\w+~')],
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'site' => 'Enter your site URL.',
        ];
    }
}
