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

<?= Form::widget()->action('widgets')->csrf($csrf)->begin(); ?>
    <?= Password::widget()->config($data, 'password')->render(); ?>
    <hr class="mt-3">
    <?= Field::widget()->submitButton(['class' => 'button is-block is-info is-fullwidth', 'value' => 'Save']); ?>
<?= Form::end(); ?>
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
`maxlength(int $value)` | Sets the maximum length of the input | `null`
`minlength(int $value)` | Sets the minimum length of the input | `null`
`pattern(string $value)` | Specifies a regular expression for validate the input | `null`
`placeholder(string $value)` | Sets the placeholder of the input | `null`
`readOnly(bool $value = true)` | Sets the input as read only | `false`

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
