# Telephone Field

Represents `<input>` element of type "tel" that lets the user enter and edit a telephone number. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#telephone-state-(type=tel))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/tel)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\Telephone;

echo Telephone::widget()
    ->name('TelephoneForm[number]')
    ->value('')
    ->inputId('telephoneform-number')
    ->label('Phone')
    ->hint('Enter your phone.');
```

Result will be:

```html
<div>
    <label for="telephoneform-number">Phone</label>
    <input type="tel" id="telephoneform-number" name="TelephoneForm[number]" value>
    <div>Enter your phone.</div>
</div>
```
