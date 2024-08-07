# Email Field

Represents `<input>` element of type "email" that lets the user enter and edit an e-mail address, or, if the "multiple"
attribute is specified, a list of e-mail addresses is accepted. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#email-state-(type=email))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/email)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\Email;

echo Email::widget()
    ->name('EmailForm[main]')
    ->value('')
    ->label('Main email')
    ->hint('Email for notifications.')
    ->inputId('emailform-main');
```

Result will be:

```html
<div>
    <label for="emailform-main">Main email</label>
    <input type="email" id="emailform-main" name="EmailForm[main]" value>
    <div>Email for notifications.</div>
</div>
```
