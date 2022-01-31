# Password widget

[Password](https://www.w3.org/TR/2012/WD-html-markup-20120329/input.password.html#input.password) represents a one-line plain-text edit control for entering a password.

## Usage

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;

final class TestForm extends FormModel
{
    public ?string $password = null;
}
```

Widget view:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\Password;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= Password::widget()->for($data, 'password') ?>
    <hr class="mt-3">
    <?= Field::widget()->class('button is-block is-info is-fullwidth')->submitButton()->value('Save') ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="I41AYSE6ox6su83E3Zt6TgmHyyWTbTuj177G5b40esdT4ixXEmn1SOrUnrLt_hgcevWITtsyV_Wd9Key-lkxrQ==">
    <input type="hidden" name="_csrf" value="I41AYSE6ox6su83E3Zt6TgmHyyWTbTuj177G5b40esdT4ixXEmn1SOrUnrLt_hgcevWITtsyV_Wd9Key-lkxrQ==">
    <input type="password" id="testform-password" name="TestForm[password]">
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-149016764207001" class="button is-block is-info is-fullwidth" name="submit-149016764207001" value="Save">
    </div>
</form>
```

### `Password` methods:

Method | Description | Default
-------|-------------|---------
`maxlength(int $value)` | Set the maximum length of the input | `null`
`minlength(int $value)` | Set the minimum length of the input | `null`
`pattern(string $value)` | Specifies a regular expression for validate the input | `null`
`placeholder(string $value)` | Set the placeholder of the input | `null`
`size(int $size)` | Set the size attribute | ``

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
