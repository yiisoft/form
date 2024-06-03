# Checkbox List Field

Represents a list of [checkboxes](checkbox.md) with multiple selection.

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\CheckboxList;

$inputData = new PureInputData(
    name: 'CheckboxListForm[color]',
    label: 'Select one or more colors',
    hint: 'Color of box.',
    id: 'UID',
);
echo CheckboxList::widget()
    ->items([
        'red' => 'Red',
        'blue' => 'Blue',
    ])
    ->inputData($inputData)
    ->render();
```

Result will be:

```html
<div>
    <label>Select one or more colors</label>
    <div>
        <label><input type="checkbox" name="CheckboxListForm[color][]" value="red"> Red</label>
        <label><input type="checkbox" name="CheckboxListForm[color][]" value="blue"> Blue</label>
    </div>
    <div>Color of box.</div>
</div>
```
