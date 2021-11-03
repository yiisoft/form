# Url widget

[Url](https://www.w3.org/TR/2012/WD-html-markup-20120329/input.url.html) represents a control for editing an absolute URL give in the element’s value.

## Usage

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;

final class TestForm extends FormModel
{
    private string $url = '';
}
```

Widget view:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\Url;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= Url::widget()->config($data, 'url') ?>
    <hr class="mt-3">
    <?= Field::widget()->submitButton(['class' => 'button is-block is-info is-fullwidth', 'value' => 'Save']) ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="ALceQYOBLVjwonfFQOuwn4sQ5_24ofe7mvf-IkjDVhFu5FUk2-5lMqbQOPUytMf8732AreDJpMHtno1XBa4QVA==">
    <input type="hidden" name="_csrf" value="ALceQYOBLVjwonfFQOuwn4sQ5_24ofe7mvf-IkjDVhFu5FUk2-5lMqbQOPUytMf8732AreDJpMHtno1XBa4QVA==">
    <input type="url" id="testform-url" name="TestForm[url]">
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-167205147300001" class="button is-block is-info is-fullwidth" name="submit-167205147300001" value="Save">
    </div>
</form>
```

### `Url` methods:

Method | Description | Default
-------|-------------|---------
`maxlength(int $value)` | Sets the maximum length of the value. | ``
`minlength(int $value)` | Sets the minimum length of the value. | ``
`pattern(string $value)` | Sets the pattern of the value. | ``
`placeholder(string $value)` | Sets the placeholder of the value. | ``
`size(int $value = 4)` | Sets the size of the value. | ``

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
