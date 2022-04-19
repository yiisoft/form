<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Validator;

final class ErrorSummaryForm extends FormModel
{
    public string $name = '';

    public function getRules(): array
    {
        return [
            'name' => [new Required()],
        ];
    }

    public function getAttributeLabels(): array
    {
        return [
            'name' => 'Your name',
        ];
    }

    public static function validated(): self
    {
        $form = new self();
        (new Validator())->validate($form);
        return $form;
    }
}
