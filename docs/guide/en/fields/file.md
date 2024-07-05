# File Field

Represents `<input>` element of type "file" that lets the user choose one or more files from their device storage. 
Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#file-upload-state-(type=file))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/file)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\File;

echo File::widget()
    ->name('avatar')
    ->inputId('id-test')
    ->label('Avatar');
```

Result will be:

```html
<div>
    <label for="id-test">Avatar</label>
    <input type="file" id="id-test" name="avatar">
</div>
```
