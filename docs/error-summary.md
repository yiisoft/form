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
            'email' => [Email::rule()],
            'name' => [HasLength::rule()->min(4)->tooShortMessage('Is too short.')],
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

    if ($method === 'POST' && $testForm->load($body) && $validator->validate($testForm)->isValid()) {
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

<?= Form::widget()->action('widgets')->csrf($csrf)->begin(); ?>
    <?= Text::widget()->config($formModel, 'name') ?>
    <?= Text::widget()->config($formModel, 'email') ?>
    <?= ErrorSummary::widget()->model($formModel) ?>
    <hr class="mt-3">
    <?= Field::widget()->submitButton(['class' => 'button is-block is-info is-fullwidth', 'value' => 'Save']); ?>
<?= Form::end(); ?>
```

That would generate the following code before validation:

```html
<form action="widgets" method="POST" novalidate="" _csrf="vWob09HzPhcTDuhOHVU71VJQAAymEm2Hysn_8QN1Y8qOXWK9tKd9J2RYsDd8DVqNJGcxduVIAvOMrq3FSjQpoQ==">
    <input type="hidden" name="_csrf" value="vWob09HzPhcTDuhOHVU71VJQAAymEm2Hysn_8QN1Y8qOXWK9tKd9J2RYsDd8DVqNJGcxduVIAvOMrq3FSjQpoQ==">
    <input type="text" id="testform-name" name="TestForm[name]">
    <input type="text" id="testform-email" name="TestForm[email]">
    <div style="display:none"><p>Please fix the following errors:</p><ul></ul></div>
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-14082948982001" class="button is-block is-info is-fullwidth" name="submit-14082948982001" value="Save">
    </div>
</form>
```

That would generate the following code after validation:
```html
<form action="widgets" method="POST" novalidate="" _csrf="9moR1LM6d8JXgqYRLTD_ba2D-fQNRSyXTddnFUQIU1XFXWi61m408iDU_mhMaJ4127TIjk4fQ-MLsDUhDUkZPg==">
    <input type="hidden" name="_csrf" value="9moR1LM6d8JXgqYRLTD_ba2D-fQNRSyXTddnFUQIU1XFXWi61m408iDU_mhMaJ4127TIjk4fQ-MLsDUhDUkZPg==">
    <input type="text" id="testform-name" name="TestForm[name]">
    <input type="text" id="testform-email" name="TestForm[email]">
    <div><p>Please fix the following errors:</p>
        <ul>
            <li>This value is not a valid email address.</li>
            <li>Is too short.</li>
        </ul>
    </div>
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-14687568353001" class="button is-block is-info is-fullwidth" name="submit-14687568353001" value="Save">
    </div>
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

<?= Form::widget()->action('widgets')->csrf($csrf)->begin(); ?>
    <?= Text::widget()->config($formModel, 'name') ?>
    <?= Text::widget()->config($formModel, 'email') ?>
    <?= ErrorSummary::widget()
        ->attributes(['class' => 'has-text-danger'])
        ->footer('Custom Footer:')
        ->header('Custom Header:')
        ->model($formModel)
    ?>
    <hr class="mt-3">
    <?= Field::widget()->submitButton(['class' => 'button is-block is-info is-fullwidth', 'value' => 'Save']); ?>
<?= Form::end(); ?>
```

That would generate the following code before validation:

```html
<form action="widgets" method="POST" novalidate="" _csrf="SNh_ZumgopPv9wpiFCMw3IioeIbaQ9w54dYmh0XRanl77wYIjPTho5ihUht1e1GE_p9J_JkZs02nsXSzDJAgEg==">    
    <input type="hidden" name="_csrf" value="SNh_ZumgopPv9wpiFCMw3IioeIbaQ9w54dYmh0XRanl77wYIjPTho5ihUht1e1GE_p9J_JkZs02nsXSzDJAgEg==">
    <input type="text" id="testform-name" name="TestForm[name]">
    <input type="text" id="testform-email" name="TestForm[email]">
    <div class="has-text-danger" style="display:none">Custom Header:<ul></ul>Custom Footer:</div>
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-20289061442001" class="button is-block is-info is-fullwidth" name="submit-20289061442001" value="Save">
    </div>
</form>
```

That would generate the following code after validation:

```html
<form action="widgets" method="POST" novalidate="" _csrf="PwqhEiBBULqjUwjVQFBIGDt2iral9LmaJNOkfEJe-BcMPdh8RRUTitQFUKwhCClATUG7zOau1u5itPZICx-yfA==">
    <input type="hidden" name="_csrf" value="PwqhEiBBULqjUwjVQFBIGDt2iral9LmaJNOkfEJe-BcMPdh8RRUTitQFUKwhCClATUG7zOau1u5itPZICx-yfA==">
    <input type="text" id="testform-name" name="TestForm[name]">
    <input type="text" id="testform-email" name="TestForm[email]">
    <div class="has-text-danger">
        Custom Header:
        <ul>
            <li>This value is not a valid email address.</li>
            <li>Is too short.</li>
        </ul>
        Custom Footer:
    </div>
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-21602903539001" class="button is-block is-info is-fullwidth" name="submit-21602903539001" value="Save">
    </div>
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
`function tag(string $value)` | Set the container tag name for the error summary. | `'div'`
