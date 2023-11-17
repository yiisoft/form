<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Length;
use Yiisoft\Validator\Rule\Regex;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\RulesProviderInterface;
use Yiisoft\Validator\Validator;

final class TextForm extends FormModel implements RulesProviderInterface
{
    public string $name = '';
    public string $job = '';
    public string $company = '';
    public string $shortdesc = '';
    public string $code = '';
    public string $nocode = '';
    public int $age = 42;
    public ?int $requiredWhen = null;
    public array $array = [];

    public function getRules(): array
    {
        return [
            'name' => [new Required(), new Length(min: 4)],
            'company' => [new Required()],
            'shortdesc' => [new Length(min: 10, max: 199)],
            'code' => [new Regex(pattern: '~\w+~')],
            'nocode' => [new Regex(pattern: '~\w+~', not: true)],
            'requiredWhen' => [new Required(when: static fn () => false)],
        ];
    }

    public function getAttributeLabels(): array
    {
        return [
            'name' => 'Name',
            'job' => 'Job',
            'company' => 'Company',
            'array' => 'Array',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'name' => 'Input your full name.',
        ];
    }

    public function getAttributePlaceholders(): array
    {
        return [
            'name' => 'Typed your name here',
        ];
    }

    public static function validated(): self
    {
        $form = new self();
        (new Validator())->validate($form);
        return $form;
    }
}
