# Select Field

Represents `<select>` element that provides a menu of options. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/form-elements.html#the-select-element)
- [MDN Web Docs](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/select)

## Usage Example

Form model:

```php
final class ProfileForm extends FormModel
{
    public ?string $color = 'f00';

    public function getAttributeLabels(): array
    {
        return [
            'color' => 'Select color',
        ];
    }
}
```

Widget:

```php
echo Select::widget()
    ->attribute($profileForm, 'color')
    ->optionsData([
        'f00' => 'Red',
        '0f0' => 'Green',
        '00f' => 'Blue',
    ]);
```

Result will be:

```html
<div>
    <label for="profileform-color">Select color</label>
    <select id="profileform-color" name="ProfileForm[color]">
        <option value="f00">Red</option>
        <option value="0f0">Green</option>
        <option value="00f">Blue</option>
    </select>
</div>
```

## Supported Values

- `string`
- number or numeric string (see [is_numeric()](https://www.php.net/manual/en/function.is-numeric.php))
- `bool`
- `null`
- any stringable values

Multiple select requires iterable or `null` value.
