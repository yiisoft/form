# Select widget

[Select](https://www.w3.org/TR/2012/WD-html-markup-20120329/select.html) is a form control that allows the user to select one or more options.

## Usage

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;

final class TestForm extends FormModel
{
    public int $cityOfBirth = 0;
}
```

Widget view:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\Select;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */

$prompt = [
    'text' => 'Select City Birth',
    'attributes' => [
        'value' => '0',
        'selected' => 'selected',
    ],
];
$groups = [
    'a' => ['label' => 'Russia'],
    'b' => ['label' => 'Chile'],
];
$citiesGroups = [
    'a' => [
        '1' => ' Moscu',
        '2' => ' San Petersburgo',
        '3' => ' Novosibirsk',
        '4' => ' Ekaterinburgo',
    ],
    'b' => [
        '5' => 'Santiago',
        '6' => 'Concepcion',
        '7' => 'Chillan',
    ],
];
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= Select::widget()->for($data, 'cityOfBirth')->groups($groups)->items($citiesGroups)->prompt($prompt) ?>
    <hr class="mt-3">
    <?= Field::widget()->class('button is-block is-info is-fullwidth')->submitButton()->value('Save') ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="1rvzUIEIEkHrdKQhm-jl0d2bmgtXjCrLCiW69nxzdRSy1oICs2RRIN8FnWXEhZXjh-jxJm7HRrg6SO6-JQAYWA==">
    <input type="hidden" name="_csrf" value="1rvzUIEIEkHrdKQhm-jl0d2bmgtXjCrLCiW69nxzdRSy1oICs2RRIN8FnWXEhZXjh-jxJm7HRrg6SO6-JQAYWA==">
    <select id="testform-cityofbirth" name="TestForm[cityOfBirth]">
        <option value="0" selected="">Select City Birth</option>
        <optgroup label="Russia">
            <option value="1"> Moscu</option>
            <option value="2"> San Petersburgo</option>
            <option value="3"> Novosibirsk</option>
            <option value="4"> Ekaterinburgo</option>
        </optgroup>
        <optgroup label="Chile">
            <option value="5">Santiago</option>
            <option value="6">Concepcion</option>
            <option value="7">Chillan</option>
        </optgroup>
    </select>
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-38635684505001" class="button is-block is-info is-fullwidth" name="submit-38635684505001" value="Save">
    </div>
</form>
```

### `Select` methods:

Method | Description | Default
-------|-------------|---------
`groups(array $value = [])` | Set the groups of the select list | `[]`
`items(array $value = [])` | Set the items of the select list | `[]`
`itemsAttributes(array $value = [])` | Set the attributes of the items of the select list | `[]`
`multiple(bool $value = true)` | If set, means the widget accepts one or more values | `false`
`optionsData(array $data, bool $encode)` | Whether option content should be HTML-encoded | `[]`
`prompt(array $value = [])` | Set the prompt of the select list | `[]`
`promptTag(?Option $value)` | The prompt option tag can be used to define an object Stringable that will be displayed on the first line of the drop-down list widget | `null`
`size(int $value = 0)` | The height of the select list with multiple is true | `0`
`unselectValue(?string $value)` | Set the value of the unselect option | `null`

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
`tabIndex(int $value)` | Set the tabindex attribute | ``
`title(string $value)` | Set the title attribute | `''`
`value(string $value)` | Set the value attribute | `''`
