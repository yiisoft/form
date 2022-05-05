# Text Field

Represents `<input>` element of type text that create basic single-line text fields. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#text-(type=text)-state-and-search-state-(type=search))
- [MDN Web Docs](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/text)

## Usage Example

Form model:

```php
final class TextForm extends FormModel
{
    public ?string $name = null;

    public function getAttributeLabels(): array
    {
        return [
            'name' => 'Full Name',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'name' => 'Input your full name.',
        ];
    }
}
```

Widget:

```php
echo Text::widget()
    ->attribute($createForm, 'name')
    ->required()
    ->render();
```

Result will be:

```html
<div>
    <label for="createform-name">Full Name</label>
    <input type="text" id="createform-name" name="CreateForm[name]">
    <div>Input your full name.</div>
</div>
```

## Supported Values

- `string`
- `null`
