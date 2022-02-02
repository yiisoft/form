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
    <?= Number::widget()->for($data, 'number') ?>
    <hr class="mt-3">
    <?= Field::widget()->class('button is-block is-info is-fullwidth')->submitButton()->value('Save') ?>
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
`autofocus(bool $value = true)` | Set the autofocus attribute | `false`
`attributes(array $attributes = [])` | The HTML attributes for the widget | `[]`
`class(string $class)` | The CSS class for the widget | `''`
`charset(string $value)` | Set the charset attribute | `UTF-8`
`disabled(bool $value = true)` | Set the disabled attribute | `false`
`encode(bool $value)` | Whether content should be HTML-encoded | `true`
`for(FormModelInterface $formModel, string $attribute)` | Configure the widget |
`id(string $value)` | Set the id attribute | `''`
`name(string $value)` | Set the name attribute. | `''`
`tabIndex(int $value)` | Set the tabindex attribute | `''`
`title(string $value)` | Set the title attribute | `''`
`value(string $value)` | Set the value attribute | `''`
