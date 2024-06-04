# File Field

Represents `<input>` element of type "file" that lets the user choose one or more files from their device storage. 
Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#file-upload-state-(type=file))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/file)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\Base\InputData\InputData;
use Yiisoft\Form\Field\File;

$inputData = new InputData(name: 'avatar', id: 'id-test', label: 'Avatar');
echo File::widget()->inputData($inputData);
```

Result will be:

```html
<div>
    <label for="id-test">Avatar</label>
    <input type="file" id="id-test" name="avatar">
</div>
```
