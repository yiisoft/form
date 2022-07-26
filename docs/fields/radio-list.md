# Radio List Field

Represents a list of radio buttons with a single selection.

## Usage Example

Form model:

```php
final class ProfileForm extends FormModel
{
    public string $color = 'red';

    public function getAttributeLabels(): array
    {
        return [
            'color' => 'Select color',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'color' => 'Your personal color.',
        ];
    }
}
```

Widget:

```php
echo RadioList::widget()
    ->formAttribute($profileForm, 'color')
    ->items([
        'f00' => 'Red',
        '0f0' => 'Green',
        '00f' => 'Blue',
    ]);
```

Result will be:

```html
<div>
    <label>Select color</label>
    <div>
        <label><input type="radio" name="ProfileForm[color]" value="f00" checked> Red</label>
        <label><input type="radio" name="ProfileForm[color]" value="0f0"> Green</label>
        <label><input type="radio" name="ProfileForm[color]" value="00f"> Blue</label>
    </div>
    <div>Your personal color.</div>
</div>
```

## Supported Values

- `string`
- number or numeric string (see [is_numeric()](https://www.php.net/manual/en/function.is-numeric.php))
- `bool`
- `null`
- any stringable values
