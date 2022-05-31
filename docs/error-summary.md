# Error summary widget

Displays a summary of the errors in a form.

## Usage

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Email;
use Yiisoft\Validator\Rule\HasLength;

final class TestForm extends FormModel
{
    private string $email = '';
    private string $name = '';

    public function getRules(): array
    {
        return [
            'email' => [new Email()],
            'name' => [new HasLength(min: 4, tooShortMessage: 'Is too short.'),
        ];
    } 
}
```

Controller action:
```php
public function widget(
    TestForm $testForm,
    ValidatorInterface $validator,
    ServerRequestInterface $serverRequest
): ResponseInterface {
    /** @var array $body */
    $body = $serverRequest->getParsedBody();
    $method = $serverRequest->getMethod();

    if ($method === 'POST' && $testForm->load($body) && $validator
        ->validate($testForm)
        ->isValid()) {
    }

    return $this->viewRenderer->render('widget', ['formModel' => $testForm]);
}
```

Widget view:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\ErrorSummary;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\Text;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */
?>

<?= Form::widget()
    ->action('widgets')
    ->csrf($csrf)
    ->begin(); ?>
    <?= Text::widget()->for($formModel, 'name') ?>
    <?= Text::widget()->for($formModel, 'email') ?>
    <?= ErrorSummary::widget()->model($formModel) ?>
    <hr class="mt-3">
    <?= SubmitButton::widget()
        ->class('button is-block is-info is-fullwidth')
        ->value('Save') ?>
<?= Form::end(); ?>
```

That would generate the following code before validation:

```html
<form action="widgets" method="POST" _csrf="vWob09HzPhcTDuhOHVU71VJQAAymEm2Hysn_8QN1Y8qOXWK9tKd9J2RYsDd8DVqNJGcxduVIAvOMrq3FSjQpoQ==">
    <input type="hidden" name="_csrf" value="vWob09HzPhcTDuhOHVU71VJQAAymEm2Hysn_8QN1Y8qOXWK9tKd9J2RYsDd8DVqNJGcxduVIAvOMrq3FSjQpoQ==">
    <input type="text" id="testform-name" name="TestForm[name]" minlength="4">
    <input type="text" id="testform-email" name="TestForm[email]">
    <hr class="mt-3">
    <input type="submit" id="w1-submit" class="button is-block is-info is-fullwidth" name="w1-submit" value="Save">
</form>
```

That would generate the following code after validation:
```html
<form action="widgets" method="POST" _csrf="vWob09HzPhcTDuhOHVU71VJQAAymEm2Hysn_8QN1Y8qOXWK9tKd9J2RYsDd8DVqNJGcxduVIAvOMrq3FSjQpoQ==">
    <input type="hidden" name="_csrf" value="vWob09HzPhcTDuhOHVU71VJQAAymEm2Hysn_8QN1Y8qOXWK9tKd9J2RYsDd8DVqNJGcxduVIAvOMrq3FSjQpoQ==">
    <input type="text" id="testform-name" name="TestForm[name]" minlength="4">
    <input type="text" id="testform-email" name="TestForm[email]">
    <div>
        <p>Please fix the following errors:</p>
        <ul>
            <li>This value is not a valid email address.</li>
            <li>Is too short.</li>
        </ul>
    </div>
    <hr class="mt-3">
    <input type="submit" id="w1-submit" class="button is-block is-info is-fullwidth" name="w1-submit" value="Save">
</form>
```

### Custom error summary

To configure a custom error summary, we simply change it in the widget, taking the previous example the code would be the following: 

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\ErrorSummary;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\Text;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */
?>

<?= Form::widget()
    ->action('widgets')
    ->csrf($csrf)
    ->begin(); ?>
    <?= Text::widget()->for($formModel, 'name') ?>
    <?= Text::widget()->for($formModel, 'email') ?>
    <?= ErrorSummary::widget()
        ->attributes(['class' => 'has-text-danger'])
        ->footer('Custom Footer:')
        ->header('Custom Header:')
        ->model($formModel)
    ?>
    <hr class="mt-3">
    <?= SubmitButton::widget()
        ->class('button is-block is-info is-fullwidth')
        ->value('Save') ?>
<?= Form::end(); ?>
```

That would generate the following code after validation:

```html
<form action="widgets" method="POST" _csrf="vWob09HzPhcTDuhOHVU71VJQAAymEm2Hysn_8QN1Y8qOXWK9tKd9J2RYsDd8DVqNJGcxduVIAvOMrq3FSjQpoQ==">
    <input type="hidden" name="_csrf" value="vWob09HzPhcTDuhOHVU71VJQAAymEm2Hysn_8QN1Y8qOXWK9tKd9J2RYsDd8DVqNJGcxduVIAvOMrq3FSjQpoQ==">
    <input type="text" id="testform-name" name="TestForm[name]" minlength="4">
    <input type="text" id="testform-email" name="TestForm[email]">
    <div class="has-text-danger">
        <p>Custom Header:</p>
        <ul>
            <li>This value is not a valid email address.</li>
            <li>Is too short.</li>
        </ul>
        <p>Custom Footer:</p>
    </div>
    <hr class="mt-3">
    <input type="submit" id="w1-submit" class="button is-block is-info is-fullwidth" name="w1-submit" value="Save">
</form>
```

### Only attributes

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\ErrorSummary;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\Text;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */
?>

<?= Form::widget()
    ->action('widgets')
    ->csrf($csrf)
    ->begin(); ?>
    <?= Text::widget()->for($formModel, 'name') ?>
    <?= Text::widget()->for($formModel, 'email') ?>
    <?= ErrorSummary::widget()
        ->attributes(['class' => 'has-text-danger'])
        ->onlyAttributes('email')
        ->model($formModel) ?>
    <hr class="mt-3">
    <?= Field::widget()
        ->class('button is-block is-info is-fullwidth')
        ->submitButton()
        ->value('Save') ?>
<?= Form::end(); ?>
```


That would generate the following code after validation:

```html
<form action="widgets" method="POST" _csrf="vWob09HzPhcTDuhOHVU71VJQAAymEm2Hysn_8QN1Y8qOXWK9tKd9J2RYsDd8DVqNJGcxduVIAvOMrq3FSjQpoQ==">
    <input type="hidden" name="_csrf" value="vWob09HzPhcTDuhOHVU71VJQAAymEm2Hysn_8QN1Y8qOXWK9tKd9J2RYsDd8DVqNJGcxduVIAvOMrq3FSjQpoQ==">
    <input type="text" id="testform-name" name="TestForm[name]" minlength="4">
    <input type="text" id="testform-email" name="TestForm[email]">
    <div class="has-text-danger">
        <p>Please fix the following errors:</p>
        <ul>
            <li>This value is not a valid email address.</li>
        </ul>
    </div>
    <hr class="mt-3">
    <input type="submit" id="w1-submit" class="button is-block is-info is-fullwidth" name="w1-submit" value="Save">
</form>
```

### `ErrorSummary` methods:

Method | Description | Default
-------|-------------|---------
`attributes(array $value)` | Sets the HTML attributes for the error summary. | `[]`
`encode(bool $value)` | Whether to encode the error summary. | `true`
`footer(string $value)` | Set the footer text for the error summary. | `''`
`header(string $value)` | Set the header text for the error summary. | `''`
`model(FormModelInterface $formModel)` | Set the model for the error summary. | `null`
`showAllErrors(bool $value)` | Whether to show all errors. | `false`
`onlyAttributes(array $value)` | Specific attributes to be included in error summary. | `''`
`tag(string $value)` | Set the container tag name for the error summary. | `'div'`
