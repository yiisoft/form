<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Stubs;

use Yiisoft\Form\Form;
use Yiisoft\Validator\Rule\Email;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\HasLength;

class LoginForm extends Form
{
    private ?string $login = null;
    private ?string $password = null;
    private bool $rememberMe = false;

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRememberMe(): bool
    {
        return $this->rememberMe;
    }

    public function login(string $value): void
    {
        $this->login = $value;
    }

    public function password(string $value): void
    {
        $this->password = $value;
    }

    public function rememberMe(bool $value): void
    {
        $this->rememberMe = $value;
    }

    public function getAttributeHints(): array
    {
        return [
            'login' => 'Write your id or email.',
            'password' => 'Write your password.'
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'login' => 'Login:',
            'password' => 'Password:',
            'rememberMe' => 'remember Me:'
        ];
    }

    public function formName(): string
    {
        return 'LoginForm';
    }

    protected function rules(): array
    {
        return [
            'login' => $this->loginRules(),
            'password' => $this->passwordRules()
        ];
    }

    private function loginRules(): array
    {
        return [
            new Required(),
            (new HasLength())
            ->min(4)
            ->max(40)
            ->tooShortMessage('Is too short.')
            ->tooLongMessage('Is too long.'),
            new Email()
        ];
    }

    private function passwordRules(): array
    {
        return [
            new Required(),
            (new HasLength())
            ->min(8)
            ->tooShortMessage('Is too short.'),
        ];
    }
}
