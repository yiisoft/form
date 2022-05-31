# Text widget

[Text](https://www.w3.org/TR/2012/WD-html-markup-20120329/input.text.html#input.text) represents a one-line plain text edit control for the input element’s value.

## Usage

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;

final class TestForm extends FormModel
{
    private string $text = '';
}
```

Widget view:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\Text;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */
?>

<?= Form::widget()
    ->action('widgets')
    ->csrf($csrf)
    ->begin() ?>
    <?= Text::widget()->for($data, 'text') ?>
    <hr class="mt-3">
    <?= Field::widget()
        ->class('button is-block is-info is-fullwidth')
        ->submitButton()
        ->value('Save') ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="4cPmG3Mu0bbYoIHWLI8Bhl40TvaOVB9ahYqdGxG4aJGFrpdJQUKS1-zRuJJz4nG0BEcl27cfcym158lTSMsF3Q==">
    <input type="hidden" name="_csrf" value="4cPmG3Mu0bbYoIHWLI8Bhl40TvaOVB9ahYqdGxG4aJGFrpdJQUKS1-zRuJJz4nG0BEcl27cfcym158lTSMsF3Q==">
    <input type="text" id="testform-text" name="TestForm[text]">
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-107932927147001" class="button is-block is-info is-fullwidth" name="submit-107932927147001" value="Save">
    </div>
</form>
```

### `Text` methods:

Method | Description | Default
-------|-------------|---------
`dirname(string $value)` | Enables submission of a value for the directionality of the element | `''`
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
