<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Stub;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\Required;

class StubForm extends FormModel
{
    private iterable $fieldArray = [];
    private bool $fieldBool = false;
    private ?string $fieldFile = null;
    private ?string $fieldString = null;

    public function attributeHints(): array
    {
        return [
            'fieldString' => 'Enter your name.'
        ];
    }

    public function attributeLabels(): array
    {
        return [];
    }

    public function fieldArray(iterable $value): void
    {
        $this->fieldArray = $value;
    }

    public function fieldBool(bool $value): void
    {
        $this->fieldBool = $value;
    }

    public function fieldFile(string $value): void
    {
        $this->fieldFile = $value;
    }

    public function fieldString(string $value): void
    {
        $this->fieldString = $value;
    }

    public function formName(): string
    {
        return 'StubForm';
    }

    protected function rules(): array
    {
        return [
            'fieldString' => $this->fieldStringRules()
        ];
    }

    private function fieldStringRules(): array
    {
        return [
            new Required(),
            (new HasLength())
            ->max(100)
        ];
    }

    public function customError(): string
    {
        return 'This is custom error message.';
    }
}
