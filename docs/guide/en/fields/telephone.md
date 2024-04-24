# Telephone Field

Represents `<input>` element of type "tel" that lets the user enter and edit a telephone number. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#telephone-state-(type=tel))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/tel)

## Usage Example

Form model:

```php
final class ProfileForm extends FormModel
{
    public ?string $phone = null;

    public function getAttributeLabels(): array
    {
        return [
            'phone' => 'Your phone number',
        ];
    }
}
```

Widget:

```php
echo Telephone::widget()
    ->formAttribute($profileForm, 'phone')
    ->pattern('[0-9]{3}-[0-9]{3}-[0-9]{4}');
```

Result will be:

```html
<div>
    <label for="profileform-phone">Your phone number</label>
    <input type="tel" id="profileform-phone" name="ProfileForm[phone]" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
</div>
```

## Supported Values

- `string`
- `null`
