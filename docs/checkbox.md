# Checkbox widget

[Checkbox](https://www.w3.org/TR/2012/WD-html-markup-20120329/input.checkbox.html#input.checkbox) is an input element with a type attribute whose value is "checkbox" represents a state or option that can be toggled.

## Usage

The `Checkbox` widget is designed to return the status of the checkbox. Generally it returns two values, by default it is `0` for unchecked, and `1` for checkeded.

You can also configure the widget to return the value only when the checkbox is checked.

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;

final class TestForm extends FormModel
{
    public bool $active = false;
}
```

Widget view:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\Checkbox;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\Label;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= Checkbox::widget()->for($data, 'active') ?>
    <hr class="mt-3">
    <?= Field::widget()->class('button is-block is-info is-fullwidth')->submitButton()->value('Save') ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="H4r91n-qkv8GzgEU8E3hhn2vSSu5jnkguqemRBysYa1OwJWHR8Txmk6kUSWGHdfnT54zYPXoDkqN1v4CefZR2w==">
    <input type="hidden" name="_csrf" value="H4r91n-qkv8GzgEU8E3hhn2vSSu5jnkguqemRBysYa1OwJWHR8Txmk6kUSWGHdfnT54zYPXoDkqN1v4CefZR2w==">
    <input type="hidden" name="TestForm[active]" value="0">
    <label><input type="checkbox" id="testform-active" name="TestForm[active]" value="1">Active</label>
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-181408062514001" class="button is-block is-info is-fullwidth" name="submit-181408062514001" value="Save">
    </div>
</form>
```

### Custom values

Custom values could be set as well. In the following example we use `1` when checkbox only checked.

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;

final class TestForm extends FormModel
{
    public bool $active = false;
}
```

Widget view:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\Checkbox;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\Label;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= Checkbox::widget()->for($data, 'active')->uncheckValue(null) ?>
    <hr class="mt-3">
    <?= Field::widget()->class('button is-block is-info is-fullwidth')->submitButton()->value('Save') ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="Oq_3knkum-2MVDBcu5v_Zbdv4j4NQWKyueB0wrSmExhr5Z_DQUD4iMQ-YG3Ny8kEhV6YdUEnFdiOkSyE0fwjbg==">
    <input type="hidden" name="_csrf" value="Oq_3knkum-2MVDBcu5v_Zbdv4j4NQWKyueB0wrSmExhr5Z_DQUD4iMQ-YG3Ny8kEhV6YdUEnFdiOkSyE0fwjbg==">
    <label><input type="checkbox" id="testform-active" name="TestForm[active]" value="1"> Active</label>
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-186398933261001" class="button is-block is-info is-fullwidth" name="submit-186398933261001" value="Save">
    </div>
</form>
```

### More custom values

In this example we use two values for checked `active` value for checked and `inactive` value for unchecked.

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;

final class TestForm extends FormModel
{
    public string $active = 'inactive';
}
```

Widget view:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\Checkbox;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\Label;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= Checkbox::widget()->for($data, 'active')->uncheckValue('inactive')->value('active') ?>
    <hr class="mt-3">
    <?= Field::widget()->class('button is-block is-info is-fullwidth')->submitButton()->value('Save') ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="ifAHTGhruJd9LvvzfoU3xmftdLx3ReD89w21FZpDXajYum8dUAXb8jVEq8II1QGnVdwO9zsjl5bAfO1T_xlt3g==">
    <input type="hidden" name="_csrf" value="ifAHTGhruJd9LvvzfoU3xmftdLx3ReD89w21FZpDXajYum8dUAXb8jVEq8II1QGnVdwO9zsjl5bAfO1T_xlt3g==">
    <input type="hidden" name="TestForm[active]" value="inactive">
    <label><input type="checkbox" id="testform-active" name="TestForm[active]" value="active"> Active</label>
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-171128066299001" class="button is-block is-info is-fullwidth" name="submit-171128066299001" value="Save">
    </div>
</form>
```


### `Checkbox` methods: 

Method | Description | Default
-------|-------------|---------
`checked(bool $value = true)` |  Check the checkbox button | `false`
`enclosedByLabel(bool $value = true)` | If the widget should be enclosed by label | `true`
`label(string $value)` | The label text | `''`
`labelAttributes(array $attributes = [])` | The HTML attributes for the label tag | `[]`
`uncheckValue($value)` | The value that will be returned when the checkbox is not checked | `0`
`tabIndex(int $value)` | Set the tabindex attribute | `0`

### `Common` methods:

Method | Description | Default
-------|-------------|---------
`attributes(array $attributes = [])` | The HTML attributes for the widget | `[]`
`autofocus(bool $value = true)` | Set the autofocus attribute | `false`
`charset(string $value)` | Set the charset attribute | `UTF-8`
`class(string $value)` | The widget CSS class | ``
`disabled()` | Set whether the element is disabled or not | `false`
`encode(bool $value)` | Whether content should be HTML-encoded | `true`
`for(FormModelInterface $formModel, string $attribute)` | Configure the widget |
`id(string $value)` | Set the id attribute | `''`
`name(string $value)` | Set the name attribute | `''`
`readonly()` | Set the readonly attribute | `false`
`required(bool $value = true)` | Set the required attribute | `false`
`title(string $value)` | Set the title attribute | `''`
`value($value)` | The value content attribute gives the default value of the field | `''`
