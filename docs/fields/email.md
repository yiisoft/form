# Email Field

Represents `<input>` element of type "email" that lets the user to enter and edit an e-mail address, or, if the "multiple"
attribute is specified, a list of e-mail addresses is accepted. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#email-state-(type=email))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/email)

## Usage Example

Form model:

```php
final class ProfileForm extends FormModel
{
    public ?string $email = null;

    public function getAttributeLabels(): array
    {
        return [
            'email' => 'Your e-mail',
        ];
    }
}
```

Widget:

```php
echo Email::widget()
    ->formAttribute($profileForm, 'email')
    ->required();
```

Result will be:

```html
<div>
    <label for="profileform-email">Your e-mail</label>
    <input type="email" id="profileform-email" name="ProfileForm[email]" required>
</div>
```

## Supported Values

- `string`
- `null`
