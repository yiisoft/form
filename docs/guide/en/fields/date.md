# Date Field

Represents `<input>` element of type "date" that lets the user enter a date, either with a textbox that validates
the input or with a special date picker interface. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#date-state-(type=date))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/date)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\Date;

echo Date::widget()
    ->name('DateForm[birthday]')
    ->value('1996-12-19')
    ->label('Your birthday')
    ->hint('Birthday date.')
    ->inputId('dateform-birthday');
```

Result will be:

```html
<div>
    <label for="dateform-birthday">Your birthday</label>
    <input type="date" id="dateform-birthday" name="DateForm[birthday]" value="1996-12-19">
    <div>Birthday date.</div>
</div>
```
