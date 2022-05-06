<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://yiisoft.github.io/docs/images/yii_logo.svg" height="100px">
    </a>
    <h1 align="center">Yii Form</h1>
    <br>
</p>

[![Latest Stable Version](https://poser.pugx.org/yiisoft/form/v/stable.png)](https://packagist.org/packages/yiisoft/form)
[![Total Downloads](https://poser.pugx.org/yiisoft/form/downloads.png)](https://packagist.org/packages/yiisoft/form)
[![Build status](https://github.com/yiisoft/form/workflows/build/badge.svg)](https://github.com/yiisoft/form/actions?query=workflow%3Abuild)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yiisoft/form/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yiisoft/form/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/yiisoft/form/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/yiisoft/form/?branch=master)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fyiisoft%2Fform%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/yiisoft/form/master)
[![static analysis](https://github.com/yiisoft/form/workflows/static%20analysis/badge.svg)](https://github.com/yiisoft/form/actions?query=workflow%3A%22static+analysis%22)
[![type-coverage](https://shepherd.dev/github/yiisoft/form/coverage.svg)](https://shepherd.dev/github/yiisoft/form)

The package helps with implementing data entry forms.

## Requirements

- PHP 8.0 or higher.

## Installation

The package could be installed with composer:

```shell
composer require yiisoft/form --prefer-dist
```

## General usage

General topics:

- [Creating Forms](docs/creating-forms.md)
- [Fields Configuration](docs/fields-configuration.md)
- [Creating and Using Custom Fields](docs/creating-fields.md)

Fields available out of the box:

- [Checkbox](docs/fields/checkbox.md)
- [CheckboxList](docs/checkboxlist.md)
- [Date](docs/date.md)
- [DateTime](docs/datetime.md)
- [DateTimeLocal](docs/datetimelocal.md)
- [Email](docs/email.md)
- [ErrorSummary](docs/error-summary.md)
- [File](docs/file.md)
- [Number](docs/number.md)
- [Password](docs/password.md)
- [Radio](docs/radio.md)
- [RadioList](docs/radiolist.md)
- [Range](docs/range.md)
- [ResetButton](docs/resetbutton.md)
- [Select](docs/select.md)
- [SubmitButton](docs/submitbutton.md)
- [Telephone](docs/telephone.md)
- [Text](docs/fields/text.md)  
- [Url](docs/url.md)

Field parts:

- [Error](docs/field-parts/error.md)
- [Hint](docs/field-parts/hint.md)
- [Label](docs/field-parts/label.md)

## Testing

### Unit testing

The package is tested with [PHPUnit](https://phpunit.de/). To run tests:

```shell
./vendor/bin/phpunit
```

### Mutation testing

The package tests are checked with [Infection](https://infection.github.io/) mutation framework with
[Infection Static Analysis Plugin](https://github.com/Roave/infection-static-analysis-plugin). To run it:

```shell
./vendor/bin/roave-infection-static-analysis-plugin
```

### Static analysis

The code is statically analyzed with [Psalm](https://psalm.dev/). To run static analysis:

```shell
./vendor/bin/psalm
```

## License

The Yii Form is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.

Maintained by [Yii Software](https://www.yiiframework.com/).

## Support the project

[![Open Collective](https://img.shields.io/badge/Open%20Collective-sponsor-7eadf1?logo=open%20collective&logoColor=7eadf1&labelColor=555555)](https://opencollective.com/yiisoft)

## Follow updates

[![Official website](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](https://www.yiiframework.com/)
[![Twitter](https://img.shields.io/badge/twitter-follow-1DA1F2?logo=twitter&logoColor=1DA1F2&labelColor=555555?style=flat)](https://twitter.com/yiiframework)
[![Telegram](https://img.shields.io/badge/telegram-join-1DA1F2?style=flat&logo=telegram)](https://t.me/yii3en)
[![Facebook](https://img.shields.io/badge/facebook-join-1DA1F2?style=flat&logo=facebook&logoColor=ffffff)](https://www.facebook.com/groups/yiitalk)
[![Slack](https://img.shields.io/badge/slack-join-1DA1F2?style=flat&logo=slack)](https://yiiframework.com/go/slack)
