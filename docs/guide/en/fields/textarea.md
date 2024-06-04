# Textarea Field

Represents `<textarea>` element which is a multi-line plain-text editing control. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/form-elements.html#the-textarea-element)
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/textarea)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\Base\InputData\InputData;
use Yiisoft\Form\Field\Textarea;

$inputData = new InputData('desc', id: 'test-id', label: 'Description');
echo Textarea::widget()->inputData($inputData);
```

Result will be:

```html
<div>
    <label for="test-id">Description</label>
    <textarea id="test-id" name="desc"></textarea>
</div>
```
