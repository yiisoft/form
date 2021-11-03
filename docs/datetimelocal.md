# DateTimeLocal widget

[DateTimeLocal](https://www.w3.org/TR/2012/WD-html-markup-20120329/input.datetime-local.html#input.datetime-local) is an input element representing a local date and time (with no timezone information).

## Usage

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;

final class TestForm extends FormModel
{
    public string $dateOfBirth = '';
}
```

Widget view:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\DateTimeLocal;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= DateTimeLocal::widget()->config($data, 'dateOfBirth') ?>
    <hr class="mt-3">
    <?= Field::widget()->submitButton(['class' => 'button is-block is-info is-fullwidth', 'value' => 'Save']) ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="obaov_DQ0lgetzPikYcaBpmAJbx9qHmjNAm5f7ftWFHR2cSJw4OEDljYYJSh4nhU6vJm1zX3FfV-Q9go84ATOw==">
    <input type="hidden" name="_csrf" value="obaov_DQ0lgetzPikYcaBpmAJbx9qHmjNAm5f7ftWFHR2cSJw4OEDljYYJSh4nhU6vJm1zX3FfV-Q9go84ATOw==">
    <input type="datetime-local" id="testform-dateofbirth" name="TestForm[dateOfBirth]">
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-12043601298001" class="button is-block is-info is-fullwidth" name="submit-12043601298001" value="Save">
    </div>
</form>
```

### `Common` methods:

Method | Description | Default
-------|-------------|---------
`autofocus(bool $value = true)` | Sets the autofocus attribute | `false`
`charset(string $value)` | Sets the charset attribute | `UTF-8`
`config(FormModelInterface $formModel, string $attribute, array $attributes = [])` | Configures the widget. |
`disabled(bool $value = true)` | Sets the disabled attribute | `false`
`form(string $value)` | Sets the form attribute | `''`
`id(string $value)` | Sets the id attribute | `''`
`min(?string $value)` | The earliest acceptable date | `''`
`max(?string $value)` | The latest acceptable date | `''`
`readonly()` | Sets the readonly attribute | `false`
`required(bool $value = true)` | Sets the required attribute | `false`
`tabIndex(int $value = 0)` | Sets the tabindex attribute | `0`
