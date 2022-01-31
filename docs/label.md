# Label widget

Displays label for a field form.

## Usage

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;

final class TestForm extends FormModel
{
    private string $name = '';
    
    public function getAttributeLabels(): array
    {
        return [
            'name' => 'First name:',
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
use Yiisoft\Form\Widget\FieldPart\Label;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\Text;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= Label::widget()->for($formModel, 'name') ?>
    <?= Text::widget()->for($formModel, 'name') ?>
    <hr class="mt-3">
    <?= Field::widget()->class('button is-block is-info is-fullwidth')->submitButton()->value('Save') ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widget" method="POST" _csrf="A6DW7BkU5HOsjrVRbr9jFO32ZulADJaTYS0q3G1n40gwl6-CfECnQ9vY7SgP5wJMm8FXkwNW-ecnSnjoJCapIw==">
    <input type="hidden" name="_csrf" value="A6DW7BkU5HOsjrVRbr9jFO32ZulADJaTYS0q3G1n40gwl6-CfECnQ9vY7SgP5wJMm8FXkwNW-ecnSnjoJCapIw==">
    <label for="testform-name">First name:</label>
    <input type="text" id="testform-name" name="TestForm[name]">
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-186948574010001" class="button is-block is-info is-fullwidth" name="submit-186948574010001" value="Save">
    </div>
</form>
```

### Custom label text

To configure a custom label text, you can specify it when the widget is used: 

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\FieldPart\Label;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\Text;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= Label::widget()->for($formModel, 'name')->label('Name:') ?>
    <?= Text::widget()->for($formModel, 'name') ?>
    <hr class="mt-3">
    <?= Field::widget()->class('button is-block is-info is-fullwidth')->submitButton()->value('Save') ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="dlD6bhQ1cOW8W5UC5SkHKWBPjxijMkEkx9-10_nKta9FZ4MAcWEz1csNzXuEcWZxFni-YuBoLlCBuOfnsIv_xA==">
    <input type="hidden" name="_csrf" value="dlD6bhQ1cOW8W5UC5SkHKWBPjxijMkEkx9-10_nKta9FZ4MAcWEz1csNzXuEcWZxFni-YuBoLlCBuOfnsIv_xA==">
    <label for="testform-name">Name:</label>
    <input type="text" id="testform-name" name="TestForm[name]">
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-188768911791001" class="button is-block is-info is-fullwidth" name="submit-188768911791001" value="Save">
    </div>
</form>
```

### `Label` methods:

Method | Description | Default
-------|-------------|---------
`attributes(array $attributes = [])` | The HTML attributes for the widget | `[]`
`encode(bool $value)` | Whether to encode the error message. | `true`
`for(FormModelInterface $formModel, string $attribute)` | Configures the widget. |
`forId(?string $value)` | The ID of a form element to associate label with. | `''`
`label(?string $value)` | The text of the label. | `''`
