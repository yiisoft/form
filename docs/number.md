# Number widget

[Number](https://www.w3.org/TR/2012/WD-html-markup-20120329/input.number.html) is a precise control for setting the element’s value to a string representing a number.

## Usage

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;

final class TestForm extends FormModel
{
    public ?int $number = null;
}
```

Widget view:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\Number;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= Number::widget()->config($data, 'number') ?>
    <hr class="mt-3">
    <?= Field::widget()->submitButton(['class' => 'button is-block is-info is-fullwidth', 'value' => 'Save']) ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="8IjQdLjML3EoO2bHaeiw5Uc68zZI4Wy1KbFuIpOIXDKA57xCi595J25UNbFZjdK3NEiwXQC-AONj-w911-UXWA==">
    <input type="hidden" name="_csrf" value="8IjQdLjML3EoO2bHaeiw5Uc68zZI4Wy1KbFuIpOIXDKA57xCi595J25UNbFZjdK3NEiwXQC-AONj-w911-UXWA==">
    <input type="number" id="testform-number" name="TestForm[number]">
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-119707291721001" class="button is-block is-info is-fullwidth" name="submit-119707291721001" value="Save">
    </div>
</form>
```

### `Number` methods:

Method | Description | Default
-------|-------------|---------
`max(int $value)` | Sets the maximum value of the number. | `null`
`min(int $value)` | Sets the minimum value of the number. | `null`
`placeholder(string $value)` | Sets the placeholder of the number. | `""`

### `Common` methods:

Method | Description | Default
-------|-------------|---------
`autofocus(bool $value = true)` | Sets the autofocus attribute | `false`
`charset(string $value)` | Sets the charset attribute | `UTF-8`
`config(FormModelInterface $formModel, string $attribute, array $attributes = [])` | Configures the widget. |
`disabled(bool $value = true)` | Sets the disabled attribute | `false`
`form(string $value)` | Sets the form attribute | `''`
`id(string $value)` | Sets the id attribute | `''`
`readonly()` | Sets the readonly attribute | `false`
`required(bool $value = true)` | Sets the required attribute | `false`
`tabIndex(int $value = 0)` | Sets the tabindex attribute | `0`
