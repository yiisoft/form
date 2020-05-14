<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://github.com/yiisoft.png" height="100px">
    </a>
    <h1 align="center">Yii Form</h1>
    <br>
</p>

The package helps with implementing data entry forms.

[![Latest Stable Version](https://poser.pugx.org/yiisoft/yii-form/v/stable.png)](https://packagist.org/packages/yiisoft/yii-form)
[![Total Downloads](https://poser.pugx.org/yiisoft/yii-form/downloads.png)](https://packagist.org/packages/yiisoft/yii-form)
[![php74](https://github.com/yiisoft/yii-form/workflows/php74/badge.svg)](https://github.com/yiisoft/yii-form/actions)
[![php80](https://github.com/yiisoft/yii-form/workflows/php80/badge.svg)](https://github.com/yiisoft/yii-form/actions)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yiisoft/yii-form/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yiisoft/yii-form/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/yiisoft/yii-form/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/yiisoft/yii-form/?branch=master)

## Installation

The package could be installed via composer:

```php
composer require yiisoft/yii-form
```

## Usage

You must create your form model by extending the abstract form class, defining all the private properties with their
respective typehint.

Example: LoginForm.php

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Email;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\HasLength;

class LoginForm extends FormModel
{
    /** Define propertys with TypeHint */
    private ?string $login = null;
    private ?string $password = null;
    private bool $rememberMe = false;

    /** Getters propertys */
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

    /** Setters propertys */
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

    /** Define labels */
    public function attributesLabels(): array
    {
        return [
            'login' => 'Login:',
            'password' => 'Password:',
            'rememberMe' => 'remember Me:'
        ];
    }

    /** Define formname */
    public function formName(): ?string
    {
        return 'LoginForm';
    }

    /** Add rules */
    protected function rules(): array
    {
        return [
            'login' => $this->loginRules()
        ];
    }

    /** Define login rules */
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
}
```

## Tests

The package is tested with [PHPUnit](https://phpunit.de/). To run tests:

```php
./vendor/bin/phpunit
```
