# Number Field

Represents `<input>` element of type "number" that lets the user enter a number. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#number-state-(type=number))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/number)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\Number;

echo Number::widget()
    ->name('NumberForm[age]')
    ->value(42)
    ->hint('Full years.')
    ->label('Your age')
    ->inputId('numberform-age');
```

Result will be:

```html
<div>
    <label for="numberform-age">Your age</label>
    <input type="number" id="numberform-age" name="NumberForm[age]" value="42">
    <div>Full years.</div>
</div>
```
