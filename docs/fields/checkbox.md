# Checkbox Field

Represents `<input>` element of type "checkbox" that rendered by default as boxes that are checked (ticked) when
activated. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#checkbox-state-(type=checkbox))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/checkbox)

## Usage Example

Form model:

```php
final class ProfileForm extends FormModel
{
    public bool $subscribe = true;

    public function getAttributeLabels(): array
    {
        return [
            'subscribe' => 'Subscribe to mailing list',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'subscribe' => 'We send emails once a month.',
        ];
    }
}
```

Widget:

```php
echo Checkbox::widget()
    ->attribute($profileForm, 'subscribe')
    ->render();
```

Result will be:

```html

<div>
    <input type="hidden" name="ProfileForm[subscribe]" value="0">
    <label>
        <input type="checkbox" id="profileform-red" name="ProfileForm[subscribe]" value="1" checked> Subscribe to mailing list
    </label>
    <div>We send emails once a month.</div>
</div>
```

## Supported Values

- `bool`
- `null`
- any stringable values
