<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Stubs;

use Yiisoft\Form\Form;

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

    public function getAttributesHints(): array
    {
        return [
            'login' => 'Write your id or email.',
            'password' => 'Write your password.'
        ];
    }

    public function getAttributesLabels(): array
    {
        return [
            'login' => 'Login:',
            'password' => 'Password:',
            'rememberMe' => 'remember Me:'
        ];
    }

    public function getFormname(): string
    {
        return 'LoginForm';
    }
}
