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
    <?= Url::widget()->for($data, 'url') ?>
    <hr class="mt-3">
    <?= Field::widget()->class('button is-block is-info is-fullwidth')->submitButton()->value('Save') ?>
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
`tabIndex(int $value)` | Set the tabindex attribute | ``
`title(string $value)` | Set the title attribute | `''`
`value(string $value)` | Set the value attribute | `''`
