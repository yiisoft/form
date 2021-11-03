# DateTime widget

[DateTime](https://www.w3.org/TR/2012/WD-html-markup-20120329/input.datetime.html#input.datetime) is the input element for setting the element’s value to a string representing a global date and time (with timezone information).

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
use Yiisoft\Form\Widget\DateTime;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= DateTime::widget()->config($data, 'dateOfBirth') ?>
    <hr class="mt-3">
    <?= Field::widget()->submitButton(['class' => 'button is-block is-info is-fullwidth', 'value' => 'Save']) ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="3rFnIz2w-C4Nneh_SajUxDkMiOwaJqfC1sBfGMsh5Lqx_RVhD-e_b3n0n00sm-OgW03GhExRzPbhh290okiu9g==">
    <input type="hidden" name="_csrf" value="3rFnIz2w-C4Nneh_SajUxDkMiOwaJqfC1sBfGMsh5Lqx_RVhD-e_b3n0n00sm-OgW03GhExRzPbhh290okiu9g==">
    <input type="datetime" id="testform-dateofbirth" name="TestForm[dateOfBirth]">
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-116240820758001" class="button is-block is-info is-fullwidth" name="submit-116240820758001" value="Save">
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
