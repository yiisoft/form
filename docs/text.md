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

<?= Form::widget()->action('widgets')->csrf($csrf)->begin(); ?>
    <?= Text::widget()->config($data, 'text')->render(); ?>
    <hr class="mt-3">
    <?= Field::widget()->submitButton(['class' => 'button is-block is-info is-fullwidth', 'value' => 'Save']); ?>
<?= Form::end(); ?>
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
`dirname(string $value)` | Enables submission of a value for the directionality of the element. | `''`
`maxlength(int $value)` | Specifies the maximum number of characters allowed in the element. | `null`
`placeholder(string $value)` | Specifies a short hint that describes the expected value of an element. | `''`
`pattern(string $value)` | Specifies a regular expression for the element. | `''`
`size(int $value = 4)` | The height of the input with multiple is true. | `4`

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
