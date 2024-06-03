# Telephone Field

Represents `<input>` element of type "tel" that lets the user enter and edit a telephone number. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#telephone-state-(type=tel))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/tel)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\Base\InputData\InputData;
use Yiisoft\Form\Field\Telephone;

$inputData = new InputData(
    name: 'TelephoneForm[number]',
    value: '',
    id: 'telephoneform-number',
    label: 'Phone',
    hint: 'Enter your phone.',
);
echo Telephone::widget()->inputData($inputData)->render();
```

Result will be:

```html
<div>
    <label for="telephoneform-number">Phone</label>
    <input type="tel" id="telephoneform-number" name="TelephoneForm[number]" value>
    <div>Enter your phone.</div>
</div>
```
