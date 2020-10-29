<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://github.com/yiisoft.png" height="100px">
    </a>
    <h1 align="center">Yii Form</h1>
    <br>
</p>

The package helps with implementing data entry forms.

[![Latest Stable Version](https://poser.pugx.org/yiisoft/form/v/stable.png)](https://packagist.org/packages/yiisoft/form)
[![Total Downloads](https://poser.pugx.org/yiisoft/form/downloads.png)](https://packagist.org/packages/yiisoft/form)
[![Build status](https://github.com/yiisoft/form/workflows/build/badge.svg)](https://github.com/yiisoft/form/actions?query=workflow%3Abuild)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yiisoft/form/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yiisoft/form/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/yiisoft/form/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/yiisoft/form/?branch=master)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fyiisoft%2Fform%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/yiisoft/form/master)
[![static analysis](https://github.com/yiisoft/form/workflows/static%20analysis/badge.svg)](https://github.com/yiisoft/form/actions?query=workflow%3A%22static+analysis%22)

### Installation

The package could be installed via composer:

```php
composer require yiisoft/form
```

### Usage

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
    /** Define properties with TypeHint */
    private ?string $login = null;
    private ?string $password = null;
    private bool $rememberMe = false;

    /** Getters properties */
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

    /** Setters properties */
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
    public function attributeLabels(): array
    {
        return [
            'login' => 'Login:',
            'password' => 'Password:',
            'rememberMe' => 'remember Me:'
        ];
    }

    /** Define form name */
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

### Unit testing

The package is tested with [PHPUnit](https://phpunit.de/). To run tests:

```php
./vendor/bin/phpunit
```

### Mutation testing

The package tests are checked with [Infection](https://infection.github.io/) mutation framework. To run it:

```php
./vendor/bin/infection
```

### Static analysis

The code is statically analyzed with [Psalm](https://psalm.dev/). To run static analysis:

```php
./vendor/bin/psalm
```
