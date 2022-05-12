# Url Field

Represents `<input>` element of type "url" are let the user enter and edit a URL. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#url-state-(type=url))
- [MDN Web Docs](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/url)

## Usage Example

Form model:

```php
final class ProfileForm extends FormModel
{
    public ?string $site = null;

    public function getAttributeLabels(): array
    {
        return [
            'site' => 'Your site',
        ];
    }
}
```

Widget:

```php
echo Url::widget()->attribute($profileForm, 'site');
```

Result will be:

```html
<div>
    <label for="profileform-site">Your site</label>
    <input type="url" id="profileform-site" name="ProfileForm[site]">
</div>
```

## Supported Values

- `string`
- `null`
