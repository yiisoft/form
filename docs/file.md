# File widget

[File](https://www.w3.org/TR/2012/WD-html-markup-20120329/input.file.html#input.file) is an input element that represents a list of file items, each consisting of a file name, a file type, and a file body (the contents of the file).

## Usage

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;

final class TestForm extends FormModel
{
    private array $attachFiles = [];
}
```

Widget view:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\File;
use Yiisoft\Form\Widget\Form;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= File::widget()->for($data, 'attachFiles') ?>
    <hr class="mt-3">
    <?= Field::widget()->class('button is-block is-info is-fullwidth')->submitButton()->value('Save') ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="WmTTWFg8aEFC-PZf9n_JrjxF4Tgy-frRERntvNNA3iAqC79ua28-FwSXpSnGGqv8TzeiU3qmlodbU4zrly2VSg==">
    <input type="hidden" name="_csrf" value="WmTTWFg8aEFC-PZf9n_JrjxF4Tgy-frRERntvNNA3iAqC79ua28-FwSXpSnGGqv8TzeiU3qmlodbU4zrly2VSg==">
    <input type="file" id="testform-attachfiles" name="TestForm[attachFiles][]">
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-64649334142001" class="button is-block is-info is-fullwidth" name="submit-64649334142001" value="Save">
    </div>
</form>
```

### `File` methods:

Method | Description | Default
-------|-------------|---------
`accept(string $value)` | The accept attribute value is a string that defines the file types the file input should accept | ``
`hiddenAttributes(array $value)` | The HTML attributes for tag hidden uncheck value | `[]`
`multiple(bool $value = true)` | The multiple attribute specifies whether the file input should allow multiple files to be selected | `false`
`uncheckValue($value)` | The value that corresponds to "unchecked" state of the input | `null`

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
