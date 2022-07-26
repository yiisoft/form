# Button Group Field

Represents a button group widget.

## Usage Example

Widget:

```php
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
