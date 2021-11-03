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
    <?= Select::widget()->config($data, 'cityOfBirth')->groups($groups)->items($citiesGroups)->prompt($prompt) ?>
    <hr class="mt-3">
    <?= Field::widget()->submitButton(['class' => 'button is-block is-info is-fullwidth', 'value' => 'Save']) ?>
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
`groups(array $value = [])` | Sets the groups of the select list. | `[]`
`items(array $value = [])` | Sets the items of the select list. | `[]`
`itemsAttributes(array $value = [])` | Sets the attributes of the items of the select list. | `[]`
`multiple(bool $value = true)` | If set, means the widget accepts one or more values. | `false`
`optionsData(array $data, bool $encode)` | Whether option content should be HTML-encoded. | `[]`
`prompt(array $value = [])` | Sets the prompt of the select list. | `[]`
`size(int $value = 0)` | The height of the select list with multiple is true. | `0`
`unselectValue(?string $value)` | Sets the value of the unselect option. | `null`

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
