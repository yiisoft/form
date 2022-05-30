# Date Field

Represents `<input>` element of type "date" that lets the user enter a date, either with a textbox that validates
the input or with a special date picker interface. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#date-state-(type=date))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/date)

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
echo Date::widget()
    ->formAttribute($createForm, 'publishDate')
    ->min('2022-01-01')
    ->max('2038-12-31');
```

Result will be:

```html
<div>
    <label for="createform-publishdate">Publish date</label>
    <input type="date" id="createform-publishdate" name="CreateForm[publishDate]" min="2022-01-01" max="2038-12-31">
    <div>Input publish date of post.</div>
</div>
```

## Supported Values

- `string`
- `null`
