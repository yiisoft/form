# File Field

Represents `<input>` element of type "file" that lets the user to choose one or more files from their device storage. 
Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#file-upload-state-(type=file))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/file)

## Usage Example

Form model:

```php
final class ProfileForm extends FormModel
{
    private ?string $avatar = null;

    public function getAttributeLabels(): array
    {
        return [
            'avatar' => 'Choose a profile picture',
        ];
    }
}
```

Widget:

```php
echo File::widget()
    ->formAttribute($profileForm, 'avatar')
    ->accept('image/png, image/jpeg');
```

Result will be:

```html
<div>
    <label for="profileform-avatar">Choose a profile picture</label>
    <input type="file" id="profileform-avatar" name="ProfileForm[avatar]" accept="image/png, image/jpeg">
</div>
```

## Supported Values

- `string`
- `null`
- any stringable values
