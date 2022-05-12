# DateTimeLocal Field

Represents `<input>` element of type "datetime-local" are let the user easily enter both a date and a time, including
the year, month, and day as well as the time in hours and minutes. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#local-date-and-time-state-(type=datetime-local))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/datetime-local)

## Usage Example

Form model:

```php
final class CreateForm extends FormModel
{
    public ?string $publishDate = null;

    public function getAttributeLabels(): array
    {
        return [
            'name' => 'Publish date',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'name' => 'Input publish date of post.',
        ];
    }
}
```

Widget:

```php
echo DateTimeLocal::widget()
    ->attribute($createForm, 'publishDate')
    ->min('2022-01-01T00:00')
    ->max('2038-12-31T19:30');
```

Result will be:

```html
<div>
    <label for="createform-publishdate">Publish date</label>
    <input type="datetime-local" id="createform-publishdate" name="CreateForm[publishDate]" min="2022-01-01T00:00" max="2038-12-31T19:30">
    <div>Input publish date of post.</div>
</div>
```

## Supported Values

- `string`
- `null`
