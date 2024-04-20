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
[![Code Coverage](https://codecov.io/gh/yiisoft/form/graph/badge.svg?token=7JVVOMMKCZ)](https://codecov.io/gh/yiisoft/form)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fyiisoft%2Fform%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/yiisoft/form/master)
[![static analysis](https://github.com/yiisoft/form/workflows/static%20analysis/badge.svg)](https://github.com/yiisoft/form/actions?query=workflow%3A%22static+analysis%22)
[![type-coverage](https://shepherd.dev/github/yiisoft/form/coverage.svg)](https://shepherd.dev/github/yiisoft/form)
[![psalm-level](https://shepherd.dev/github/yiisoft/form/level.svg)](https://shepherd.dev/github/yiisoft/form)

The package provides a set of widgets to help with dynamic server-side generation of HTML forms. The following widgets are available out of the box:

- input fields: `Checkbox`, `CheckboxList`, `Date`, `DateTime`, `DateTimeLocal`, `Email`, `File`, `Hidden`, `Image`, 
`Number`, `Password`, `RadioList`, `Range`, `Select`, `Telephone`, `Text`, `Textarea`, `Time`, `Url`;
- buttons: `Button`, `ResetButton`, `SubmitButton`;
- group widgets: `ButtonGroup`, `Fieldset`. 
- other: `ErrorSummary`.

Two themes are available out of the box:

- Bootstrap 5 Horizontal,
- Bootstrap 5 Vertical.

## Requirements

- PHP 8.1 or higher.
- `mbstring` PHP extension.

## Installation

The package could be installed with composer:

```shell
composer require yiisoft/form
```

## General usage

Configure themes (optional):

```php
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Form\ThemePath;

ThemeContainer::initialize(
    config: [
        'vertical' => require ThemePath::BOOTSTRAP5_VERTICAL,
        'horizontal' => require ThemePath::BOOTSTRAP5_HORIZONTAL,
    ],
    defaultConfig: 'vertical',
);
```

... and use `PureField` helper to create widgets:

```php
use Yiisoft\Form\PureField;

echo PureField::text('firstName', theme: 'horizontal')->label('First Name')->autofocus();
echo PureField::text('lastName', theme: 'horizontal')->label('Last Name');
echo PureField::select('sex')->label('Sex')->optionsData(['m' => 'Male', 'f' => 'Female'])->prompt('—');
echo PureField::number('age')->label('Age')->hint('Please enter your age.');
echo PureField::submitButton('Submit')->buttonClass('primary');
```

The result of executing the code above will be:

```html
<div class="mb-3 row">
    <label class="col-sm-2 col-form-label">First Name</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="firstName" autofocus>
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-2 col-form-label">Last Name</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="lastName">
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Sex</label>
    <select class="form-select" name="sex">
        <option value>—</option>
        <option value="m">Male</option>
        <option value="f">Female</option>
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Age</label>
    <input type="number" class="form-control" name="age">
    <div class="form-text">Please enter your age.</div>
</div>
<div class="mb-3">
    <button type="submit" class="primary">Submit</button>
</div>
```

## Documentation

- [Internals](docs/internals.md)

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
