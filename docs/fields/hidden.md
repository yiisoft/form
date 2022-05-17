# Hidden Field

Represents `<input>` element of type "hidden" are let web developers include data that cannot be seen or modified by
users when a form is submitted. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#hidden-state-(type=hidden))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/hidden)

## Usage Example

Form model:

```php
final class ProfileForm extends FormModel
{
    public string $action = 'update';
}
```

Widget:

```php
echo Hidden::widget()->formAttribute($profileForm, 'action');
```

Result will be:

```html
<input type="hidden" id="profileform-action" name="ProfileForm[action]" value="update">
```

## Supported Values

- `string`
- number or numeric string (see [is_numeric()](https://www.php.net/manual/en/function.is-numeric.php))
- `null`
