<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Stub;

use Yiisoft\Form\Form;
use Yiisoft\Validator\Rule\Email;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\Rule\Required;

final class PersonalForm extends Form
{
    private ?int $id = null;
    private ?string $email = null;
    private ?string $name = null;
    private int $cityBirth = 0;
    private ?string $entryDate = null;
    private ?int $sex = null;
    private bool $terms = false;

    public function attributeLabels(): array
    {
        return [];
    }

    public function formname(): string
    {
        return 'PersonalForm';
    }

    protected function rules(): array
    {
        return [
            'name' => [(new Required()), (new HasLength())->min(4)->tooShortMessage('Is too short.')],
            'email' => [(new Email())]
        ];
    }


    public function cityBirth(int $value): void
    {
        $this->cityBirth = $value;
    }

    public function email(string $value): void
    {
        $this->email = $value;
    }

    public function entryDate(string $value): void
    {
        $this->entryDate = $value;
    }

    public function name(string $value): void
    {
        $this->name = $value;
    }

    public function sex(int $value): void
    {
        $this->sex = $value;
    }

    public function terms(bool $value): void
    {
        $this->terms = $value;
    }
}
