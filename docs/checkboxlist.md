# CheckboxList widget

Generates a list of checkboxes with multiple selection.

## Usage

You can also configure the widget to return the index of the selected items.

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;

final class TestForm extends FormModel
{
    public array $fruits = [];
}
```

Widget view:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\CheckboxList;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\Label;

/**
 * @var FormModelInterface $data
 * @var string $csrf
 */
?>

<?= Form::widget()
    ->action('widgets')
    ->csrf($csrf)
    ->begin() ?>
    <?= CheckboxList::widget()
        ->for($data, 'fruits')
        ->items(['0' => 'Apple', '1' => 'Banana']) ?>
    <hr class="mt-3">
    <?= Field::widget()
        ->class('button is-block is-info is-fullwidth')
        ->submitButton()
        ->value('Save') ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="SkyVfK1kBT8znzdHXxji4bHH-iKexH29qjsg6C1X4IISOOcUmwl_e3rUaHQwR9eL04a5aaiNT_XhaU27XAiBsg==">
    <input type="hidden" name="_csrf" value="SkyVfK1kBT8znzdHXxji4bHH-iKexH29qjsg6C1X4IISOOcUmwl_e3rUaHQwR9eL04a5aaiNT_XhaU27XAiBsg==">
    <div id="testform-fruits">
        <label><input type="checkbox" name="TestForm[fruits][]" value="0"> Apple</label>
        <label><input type="checkbox" name="TestForm[fruits][]" value="1"> Banana</label>
    </div>
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-157068019452001" class="button is-block is-info is-fullwidth" name="submit-157068019452001" value="Save">
    </div>
</form>
```

### Custom values

Custom values could be set as well. In this example we use two values for selection states (`Apple`, `Banana`), returns an array, which can one value, or both values. 

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;

final class TestForm extends FormModel
{
    public array $fruits = [];
}
```

Widgets view:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\Widget\CheckboxList;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\Label;
?>

<?= Form::widget()
    ->action('widgets')
    ->csrf($csrf)
    ->begin() ?>
    <?= CheckboxList::widget()
        ->for($data, 'fruits')
        ->itemsFromValues(['0' => 'Apple', '1' => 'Banana']) ?>
    <hr class="mt-3">
    <?= Field::widget()
        ->class('button is-block is-info is-fullwidth')
        ->submitButton()
        ->value('Save') ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="gBk0hCqdvL5PP6GWH6_26zrZK-SU9q-xLFUrnaLLxQnYbUbsHPDG-gZ0_qVw8MOBWJhor6K_nflnB0bO05SkOQ==">
    <input type="hidden" name="_csrf" value="gBk0hCqdvL5PP6GWH6_26zrZK-SU9q-xLFUrnaLLxQnYbUbsHPDG-gZ0_qVw8MOBWJhor6K_nflnB0bO05SkOQ==">
    <div id="testform-fruits">
        <label><input type="checkbox" name="TestForm[fruits][]" value="Apple"> Apple</label>
        <label><input type="checkbox" name="TestForm[fruits][]" value="Banana"> Banana</label>
    </div>
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-163302772204001" class="button is-block is-info is-fullwidth" name="submit-163302772204001" value="Save">
    </div>
</form>
```

### `CheckboxList` methods: 

Method | Description | Default
-------|-------------|---------
`autofocus(bool $value = true)` | Set the autofocus widget | `false`
`containerAttributes(array $attributes)` | HTML attributes for the container tag | `[]`
`containerTag(?string $tag = null)` | Tag name of the container element | `div`
`id(?string $id = null)` | Set the ID of container the widget | `null`
`individualItemsAttributes(array $attributes = [])` | HTML attributes for individual checkbox elements | `[]`
`items(array $items = [])` | List of checkbox items for array keys | `[]`
`itemsAttributes(array $attributes = [])` | HTML attributes for checkbox elements | `[]`
`itemsFormatter(?Closure $formatter)` | Formatter for the checkbox items | `null`
`itemsFromValues(array $itemsFromValues = [])` | List of checkbox items for array values | `[]`
`separator(string $separator)` | HTML to add between each checkbox element | `&nbsp;`
`tabIndex(int $value)` | Set the tabindex attribute | `''`

### `Common` methods:

Method | Description | Default
-------|-------------|---------
`attributes(array $attributes = [])` | The HTML attributes for the widget | `[]`
`charset(string $value)` | Sets the charset attribute | `UTF-8`
`disabled()` | Set whether the element is disabled or not | `false`
`encode(bool $value)` | Whether content should be HTML-encoded | `true`
`for(FormModelInterface $formModel, string $attribute)` | Configure the widget |
`name(string $value)` | Set the name attribute | `''`
`value($value)` | The value content attribute gives the default value of the field | `''`
