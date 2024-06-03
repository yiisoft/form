# DateTimeLocal Field

Represents `<input>` element of type "datetime-local" that lets the user to easily enter both a date and a time, including
the year, month, and day as well as the time in hours and minutes. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#local-date-and-time-state-(type=datetime-local))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/datetime-local)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\Base\InputData\InputData;
use Yiisoft\Form\Field\DateTimeLocal;

$inputData = new InputData(
    name: 'partyDate',
    value: '2017-06-01T08:30',
    label: 'Date of party',
    hint: 'Party date.',
    id: 'datetimelocalform-partydate',
);
echo DateTimeLocal::widget()->inputData($inputData)->render();
```

Result will be:

```html
<div>
    <label for="datetimelocalform-partydate">Date of party</label>
    <input type="datetime-local" id="datetimelocalform-partydate" name="partyDate" value="2017-06-01T08:30">
    <div>Party date.</div>
</div>
```
