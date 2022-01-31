# Telephone widget

[Telephone](https://www.w3.org/TR/2012/WD-html-markup-20120329/input.tel.html#input.tel) represents a one-line plain-text edit control for entering a telephone number.

## Usage

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;

final class TestForm extends FormModel
{
    private string $phoneNumber = '';
}
```

Widget view:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\Telephone;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= Telephone::widget()->for($data, 'phoneNumber') ?>
    <hr class="mt-3">
    <?= Field::widget()->class('button is-block is-info is-fullwidth')->submitButton()->value('Save') ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="en29GwyIKyFYUSq5NXy1I1hicrGmoFLHnvKOYvVxyEceEMxJPuRoQGwgE_1qEcURAhEZnJ_rPrSun9oqrAKlCw==">
    <input type="hidden" name="_csrf" value="en29GwyIKyFYUSq5NXy1I1hicrGmoFLHnvKOYvVxyEceEMxJPuRoQGwgE_1qEcURAhEZnJ_rPrSun9oqrAKlCw==">
    <input type="tel" id="testform-phonenumber" name="TestForm[phoneNumber]">
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-63977381274001" class="button is-block is-info is-fullwidth" name="submit-63977381274001" value="Save">
    </div>
</form>
```

### `Telephone` methods:

Method | Description | Default
-------|-------------|---------
`maxlength(int $value)` | Set the maximum number of characters the user can enter | `null`
`minlength(int $value)` | Set the minimum number of characters the user can enter | `null`
`pattern(string $value)` | Set the regular expression pattern the user's input must match | `null`
`placeholder(string $value)` | Set the placeholder text to be displayed in the input | `null`
`size(int $value)` | Set the height of the input | `null`

### `Common` methods:

Method | Description | Default
-------|-------------|---------
`autofocus(bool $value = true)` | Set the autofocus attribute | `false`
`attributes(array $attributes = [])` | The HTML attributes for the widget | `[]`
`class(string $class)` | The CSS class for the widget | `''`
`charset(string $value)` | Set the charset attribute | `UTF-8`
`disabled(bool $value = true)` | Set the disabled attribute | `false`
`encode(bool $value)` | Whether content should be HTML-encoded | `true`
`id(string $value)` | Set the id attribute | `''`
`name(string $value)` | Set the name attribute. | `''`
`tabIndex(int $value)` | Set the tabindex attribute | `''`
`title(string $value)` | Set the title attribute | `''`
`value(string $value)` | Set the value attribute | `''`
