# Password Field

Represents `<input>` element of type "password" that lets the user to securely enter a password. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#password-state-(type=password))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/password)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\Password;

echo Password::widget()
    ->name('PasswordForm[old]')
    ->value('')
    ->label('Old password')
    ->hint('Enter your old password.')
    ->inputId('passwordform-old');
```

Result will be:

```html
<div>
    <label for="passwordform-old">Old password</label>
    <input type="password" id="passwordform-old" name="PasswordForm[old]" value>
    <div>Enter your old password.</div>
</div>
```
