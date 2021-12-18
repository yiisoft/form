<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Validator;

final class InputTextForm extends FormModel
{
    public string $name = '';
    public string $job = '';

    public function getRules(): array
    {
        return [
            'name' => [Required::rule(), HasLength::rule()->min(4)],
        ];
    }

    public function getAttributeLabels(): array
    {
        return [
            'name' => 'Name',
            'job' => 'Job',
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
