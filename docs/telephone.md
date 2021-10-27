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

<?= Form::widget()->action('widgets')->csrf($csrf)->begin(); ?>
    <?= Telephone::widget()->config($data, 'phoneNumber')->render(); ?>
    <hr class="mt-3">
    <?= Field::widget()->submitButton(['class' => 'button is-block is-info is-fullwidth', 'value' => 'Save']); ?>
<?= Form::end(); ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" novalidate="" _csrf="en29GwyIKyFYUSq5NXy1I1hicrGmoFLHnvKOYvVxyEceEMxJPuRoQGwgE_1qEcURAhEZnJ_rPrSun9oqrAKlCw==">
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
`maxlength(int $value)` | Sets the maximum number of characters the user can enter. | `null`
`minlength(int $value)` | Sets the minimum number of characters the user can enter. | `null`
`pattern(string $value)` | Sets the regular expression pattern the user's input must match. | `null`
`placeholder(string $value)` | Sets the placeholder text to be displayed in the input. | `null`
`size(int $value)` | Sets the height of the input. | `null`

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
