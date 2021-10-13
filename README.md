<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://yiisoft.github.io/docs/images/yii_logo.svg" height="100px">
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
[![type-coverage](https://shepherd.dev/github/yiisoft/form/coverage.svg)](https://shepherd.dev/github/yiisoft/form)

### Installation

The package could be installed via composer:

```shell
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
    public function formName(): string
    {
        return 'LoginForm';
    }

    /** Add rules */
    public function rules(): array
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

## Widgets usage

The following documentation describes how to use widgets with PHP:

- [Checkbox](docs/checkbox.md)
- [CheckboxList](docs/checkboxlist.md)
- [Radio](docs/radio.md)
- [RadioList](docs/radiolist.md)

### Unit testing

The package is tested with [PHPUnit](https://phpunit.de/). To run tests:

```shell
./vendor/bin/phpunit
```

### Mutation testing

The package tests are checked with [Infection](https://infection.github.io/) mutation framework. To run it:

```shell
./vendor/bin/infection
```

### Static analysis

The code is statically analyzed with [Psalm](https://psalm.dev/). To run static analysis:

```shell
./vendor/bin/psalm
```

### Support the project

[![Open Collective](https://img.shields.io/badge/Open%20Collective-sponsor-7eadf1?logo=open%20collective&logoColor=7eadf1&labelColor=555555)](https://opencollective.com/yiisoft)

### Follow updates

[![Official website](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](https://www.yiiframework.com/)
[![Twitter](https://img.shields.io/badge/twitter-follow-1DA1F2?logo=twitter&logoColor=1DA1F2&labelColor=555555?style=flat)](https://twitter.com/yiiframework)
[![Telegram](https://img.shields.io/badge/telegram-join-1DA1F2?style=flat&logo=telegram)](https://t.me/yii3en)
[![Facebook](https://img.shields.io/badge/facebook-join-1DA1F2?style=flat&logo=facebook&logoColor=ffffff)](https://www.facebook.com/groups/yiitalk)
[![Slack](https://img.shields.io/badge/slack-join-1DA1F2?style=flat&logo=slack)](https://yiiframework.com/go/slack)

## License

The Yii Form is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.

Maintained by [Yii Software](https://www.yiiframework.com/).
