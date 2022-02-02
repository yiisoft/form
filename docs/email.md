# Email widget

[Email](https://www.w3.org/TR/2012/WD-html-markup-20120329/input.email.html#input.email) is an input element for editing a list of e-mails.

## Usage

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;

final class TestForm extends FormModel
{
    public string $email = '';
}
```

Widget view:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\Email;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= Email::widget()->for($data, 'email') ?>
    <hr class="mt-3">
    <?= Field::widget()->class('button is-block is-info is-fullwidth')->submitButton()->value('Save') ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="aqOSIrAAlb-ZZI-M8OWYQd8hkpCTXEYVqQpAz4y3o-YazP4Ug1PD6d8L3PrAgPoTrFPR-9sDKkPjQCGYyNrojA==">
    <input type="hidden" name="_csrf" value="aqOSIrAAlb-ZZI-M8OWYQd8hkpCTXEYVqQpAz4y3o-YazP4Ug1PD6d8L3PrAgPoTrFPR-9sDKkPjQCGYyNrojA==">
    <input type="email" id="testform-email" name="TestForm[email]">
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-30061675597001" class="button is-block is-info is-fullwidth" name="submit-30061675597001" value="Save">
    </div>
</form>
```

### `Email` methods:

Method | Description | Default
-------|-------------|---------
`maxlength(int $length)` | Set the maximum length of the input | `''`
`minlength(int $length)` | Set the minimum length of the input | `''`
`multiple(bool $value = true)` | Specifies that the element allows multiple values | `''`
`pattern(string $value)` | Specifies a regular expression for validate the input | `''`
`placeholder(string $value)` | Set the placeholder of the input | `''`
`size(int $size)` | The height with multiple is true | `''`

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
`tabIndex(int $value)` | Set the tabindex attribute | `''`
`title(string $value)` | Set the title attribute | `''`
`value(string $value)` | Set the value attribute | `''`
