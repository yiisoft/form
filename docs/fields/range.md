# Range Field

Represents `<input>` element of type "range" are let the user specify a numeric value which must be no less than a given
value, and no more than another given value. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#range-state-(type=range))
- [MDN Web Docs](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/range)

## Usage Example

Form model:

```php
final class ProfileForm extends FormModel
{
    public ?int $age = null;

    public function getAttributeLabels(): array
    {
        return [
            'age' => 'Your age',
        ];
    }
}
```

Widget:

```php
echo Number::widget()
    ->attribute($profileForm, 'age')
    ->min(21)
    ->max(150);
```

Result will be:

```html
<div>
    <label for="profileform-age">Your age</label>
    <input type="range" id="profileform-age" name="ProfileForm[age]" min="21" max="150">
</div>
```

## Supported Values

- `string`
- number or numeric string (see [is_numeric()](https://www.php.net/manual/en/function.is-numeric.php))
- `null`
