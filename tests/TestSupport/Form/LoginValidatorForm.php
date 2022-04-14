<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\Rule\Required\Required;

final class LoginValidatorForm extends FormModel
{
    private ?string $login = '';
    private ?string $password = '';
    private array $users = ['admin' => 'admin', 'user' => 'user'];

    public function getRules(): array
    {
        return [
            'login' => [new Required()],
            'password' => $this->passwordRules(),
        ];
    }

    private function passwordRules(): array
    {
        $formErrors = $this->getFormErrors();
        $login = $this->login;
        $password = $this->password;
        $users = $this->users;

        return [
            new Required(),
            static function () use ($formErrors, $login, $password, $users): Result {
                $result = new Result();

                if (!in_array($login, $users, true) || $password !== $users[$login]) {
                    $formErrors->addError('login', '');
                    $result->addError('invalid login password');
                }

                return $result;
            },
        ];
    }
}
