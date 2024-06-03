# Checkbox Field

Represents `<input>` element of type "checkbox" that rendered by default as boxes that are checked (ticked) when
activated. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#checkbox-state-(type=checkbox))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/checkbox)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\Base\InputData\InputData;
use Yiisoft\Form\Field\Checkbox;

$inputData = new InputData(
    name: 'CheckboxForm[red]',
    value: '1',
    label: 'Red color',
    hint: 'If need red color.',
    id: 'checkboxform-red',
);
echo Checkbox::widget()->inputData($inputData)->render();
```

Result will be:

```html
<div>
    <input type="hidden" name="CheckboxForm[red]" value="0">
    <label><input type="checkbox" id="checkboxform-red" name="CheckboxForm[red]" value="1" checked> Red color</label>
    <div>If need red color.</div>
</div>
```
