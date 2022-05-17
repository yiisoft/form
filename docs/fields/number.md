# Number Field

Represents `<input>` element of type "number" are let the user enter a number. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#number-state-(type=number))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/number)

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
    ->formAttribute($profileForm, 'age')
    ->min(21)
    ->max(150);
```

Result will be:

```html
<div>
    <label for="profileform-age">Your age</label>
    <input type="number" id="profileform-age" name="ProfileForm[age]" min="21" max="150">
</div>
```

## Supported Values

- number or numeric string (see [is_numeric()](https://www.php.net/manual/en/function.is-numeric.php)) 
- `null`
