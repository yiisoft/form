# Button Group Field

Represents a group of [buttons](button.md), multiple types can be used.

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\ButtonGroup;

echo ButtonGroup::widget()
    ->buttons(
        Html::resetButton('Reset Data'),
        Html::submitButton('Send'),
    );
```

Result will be:

```html
<div>
    <button type="reset">Reset Data</button>
    <button type="submit">Send</button>
</div>
```
