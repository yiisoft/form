# Password Field

Represents `<input>` element of type "password" that lets the user to securely enter a password. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#password-state-(type=password))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/password)

## Usage Example

Form model:

```php
final class ProfileForm extends FormModel
{
    public ?string $password = null;

    public function getAttributeLabels(): array
    {
        return [
            'password' => 'Enter password',
        ];
    }
}
```

Widget:

```php
echo Password::widget()
    ->formAttribute($profileForm, 'password')
    ->minlength(8);
```

Result will be:

```html
<div>
    <label for="profileform-password">Enter password</label>
    <input type="password" id="profileform-password" name="ProfileForm[password]" minlength="8">
</div>
```

## Supported Values

- `string`
- `null`
