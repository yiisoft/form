# CheckboxList widget

[CheckboxList] Generates a list of checkboxes with multiple selection.

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

<?= Form::widget()->action('widgets')->csrf($csrf)->begin(); ?>
    <?= CheckboxList::widget()->config($data, 'fruits')->items(['0' => 'Apple', '1' => 'Banana'])->render(); ?>
    <hr class="mt-3">
    <?= Field::widget()->submitButton(['class' => 'button is-block is-info is-fullwidth', 'value' => 'Save']); ?>
<?= Form::end(); ?>
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

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= CheckboxList::widget()->config($data, 'fruits')->itemsFromValues(['0' => 'Apple', '1' => 'Banana'])->render(); ?>
    <hr class="mt-3">
    <?= Field::widget()->submitButton(['class' => 'button is-block is-info is-fullwidth', 'value' => 'Save']); ?>
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
`containerAttributes(array $attributes)` | The HTML attributes for the container tag. | `[]`
`containerTag(?string $tag = null)` | The tag name of the container element. | `div`
`disabled(bool $value = true)` | Set whether the element is disabled or not. | `false`
`individualItemsAttributes(array $attributes = [])` | The HTML attributes for the individual checkbox elements. | `[]`
`items(array $items = [])` | The list of checkbox items for array keys. | `[]`
`itemsAttributes(array $attributes = [])` | The HTML attributes for the checkbox elements. | `[]`
`itemsFormatter(?Closure $formatter)` | The formatter for the checkbox items. | `null`
`itemsFromValues(array $itemsFromValues = [])` | The list of checkbox items for array values. | `[]`
`readonly()` | Set whether the element is readonly or not. | `false`
`separator(string $separator)` | The HTML between each checkbox element. | `&nbsp;`

### `Common` methods:

Method | Description | Default
-------|-------------|---------
`charset(string $value)` | Sets the charset attribute | `UTF-8`
`config(FormModelInterface $formModel, string $attribute, array $attributes = [])` | Configures the widget. |
`autofocus(bool $value = true)` | Sets the autofocus attribute | `false`
`disabled(bool $value = true)` | Sets the disabled attribute | `false`
`form(string $value)` | Sets the form attribute | ``
`id(string $value)` | Sets the id attribute | `''`
`required(bool $value = true)` | Sets the required attribute | `false`
`readonly()` | Sets the readonly attribute | `false`
`tabIndex(int $value = 0)` | Sets the tabindex attribute | `0`
