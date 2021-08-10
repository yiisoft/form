<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Required;

final class TypeForm extends FormModel
{
    private array $array = [];
    private bool $bool = false;
    private float $float = 0;
    private int $int = 0;
    private ?object $object = null;
    private string $string = '';
    private string $toCamelCase = '';
    private ?string $toNull = null;

    public function customError(): string
    {
        return 'This is custom error message.';
    }

    public function customErrorWithIcon(): string
    {
        return '(&#10006;) This is custom error message.';
    }

    public function getAttributeHints(): array
    {
        return [
            'string' => 'Write your text string.',
        ];
    }

    public function getRules(): array
    {
        return [
            'string' => [Required::rule()],
        ];
    }
}
