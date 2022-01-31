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
    <?= DateTime::widget()->for($data, 'dateOfBirth') ?>
    <hr class="mt-3">
    <?= Field::widget()->class('button is-block is-info is-fullwidth')->submitButton()->value('Save') ?>
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

### `DateTime` methods: 

Method | Description | Default
-------|-------------|---------
`max(?string $value)` | The latest acceptable date | `''`
`min(?string $value)` | The earliest acceptable date | `''`

### `Common` methods:

Method | Description | Default
-------|-------------|---------
`autofocus(bool $value = true)` | Sets the autofocus attribute | `false`
`attributes(array $attributes = [])` | The HTML attributes for the widget | `[]`
`class(string $class)` | The CSS class for the widget | `''`
`charset(string $value)` | Sets the charset attribute | `UTF-8`
`disabled(bool $value = true)` | Sets the disabled attribute | `false`
`encode(bool $value)` | Whether content should be HTML-encoded | `true`
`for(FormModelInterface $formModel, string $attribute)` | Configures the widget. |
`id(string $value)` | Sets the id attribute | `''`
`name(string $value)` | Sets the name attribute. | `''`
`tabIndex(int $value)` | Sets the tabindex attribute | ``
`title(string $value)` | Sets the title attribute | `''`
`value(string $value)` | Sets the value attribute | `''`
