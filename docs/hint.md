# Hint widget

Display hint for field form.

## Usage

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;

final class TestForm extends FormModel
{
    private string $name = '';

    public function getAttributeHints(): array
    {
        return [
            'name' => 'Write your first name.',
        ];
    }    
}
```

Widget view:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\Hint;
use Yiisoft\Form\Widget\Text;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= Text::widget()->config($formModel, 'name') ?>
    <?= Hint::widget()->config($formModel, 'name') ?>
    <hr class="mt-3">
    <?= Field::widget()->submitButton(['class' => 'button is-block is-info is-fullwidth', 'value' => 'Save']) ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="BJKr0W43OfWETd0B8fZbrZFOKGzxkdoOZRRcuh4B1Gk3pdK_C2N6xfMbhXiQrjr153kZFrLLtXojcw6OV0CeAg==">
    <input type="hidden" name="_csrf" value="BJKr0W43OfWETd0B8fZbrZFOKGzxkdoOZRRcuh4B1Gk3pdK_C2N6xfMbhXiQrjr153kZFrLLtXojcw6OV0CeAg==">
    <input type="text" id="testform-name" name="TestForm[name]">
    <div>Write your first name.</div>
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-74174218703001" class="button is-block is-info is-fullwidth" name="submit-74174218703001" value="Save">
    </div>
</form>
```

### Custom hint text

To configure a custom hint text, we simply change it in the widget, taking the previous example the code would be the following: 

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\Hint;
use Yiisoft\Form\Widget\Text;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= Text::widget()->config($formModel, 'name') ?>
    <?= Hint::widget()->config($formModel, 'name')->hint('Custom hint text.') ?>
    <hr class="mt-3">
    <?= Field::widget()->submitButton(['class' => 'button is-block is-info is-fullwidth', 'value' => 'Save']) ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="BJKr0W43OfWETd0B8fZbrZFOKGzxkdoOZRRcuh4B1Gk3pdK_C2N6xfMbhXiQrjr153kZFrLLtXojcw6OV0CeAg==">
    <input type="hidden" name="_csrf" value="BJKr0W43OfWETd0B8fZbrZFOKGzxkdoOZRRcuh4B1Gk3pdK_C2N6xfMbhXiQrjr153kZFrLLtXojcw6OV0CeAg==">
    <input type="text" id="testform-name" name="TestForm[name]">
    <div>Write your first name.</div>
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-74174218703001" class="button is-block is-info is-fullwidth" name="submit-74174218703001" value="Save">
    </div>
</form>
```

### `Hint` methods:

Method | Description | Default
-------|-------------|---------
`encode(bool $value)` | Whether to encode the error message. | `true`
`message(string $value)` | Error message to display. | `''`
`messageCallback(array $value)` | Callback that will be called to obtain an error message. | `[]`
`tag(string $value)` | Tag to use to display the error. | `'div'`

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
