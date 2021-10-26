# Range widget

[Range](https://www.w3.org/TR/2012/WD-html-markup-20120329/input.range.html) the input element with a type attribute whose value is "range" represents an imprecise control for setting the element’s value representing a number.

## Usage

```php
<?php

declare(strict_types=1);

namespace App\Form;

use Yiisoft\Form\FormModel;

final class TestForm extends FormModel
{
    public int $number = 0;
}
```

Widget view:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\Range;

/**
 * @var FormModelInterface $data
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin(); ?>
    <?= Range::widget()->config($data, 'number')->render(); ?>
    <hr class="mt-3">
    <?= Field::widget()->submitButton(['class' => 'button is-block is-info is-fullwidth', 'value' => 'Save']); ?>
<?= Form::end(); ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="8UkZkPtSj6jhmwhbTCGTQ77oRrAfacF_46hDJyX3bWqcCF38jzPI46SvT2gmaMAF9osNg05Y9Ufb3ghPSME6Rw==">
    <input type="hidden" name="_csrf" value="8UkZkPtSj6jhmwhbTCGTQ77oRrAfacF_46hDJyX3bWqcCF38jzPI46SvT2gmaMAF9osNg05Y9Ufb3ghPSME6Rw==">
    <input type="range" id="testform-number" name="TestForm[number]" value="0" oninput="i304985617645001.value=this.value">
    <output id="i304985617645001" name="i304985617645001" for="TestForm[number]">0</output>
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-304985635933001" class="button is-block is-info is-fullwidth" name="submit-304985635933001" value="Save">
    </div>
</form>
```

### `Range` methods:

Method | Description | Default
-------|-------------|---------
`max(int $value)` | Sets the maximum value of the range. | `100`
`min(int $value)` | Sets the minimum value of the range. | `0`
`outputAttributes(array $value)` | Sets the attributes of the output element. | `[]`
`outputTag(string $value)` | Sets the tag of the output element. | `'output'`

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
