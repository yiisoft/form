# Select Field

Represents `<select>` element that provides a menu of options. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/form-elements.html#the-select-element)
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/select)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\Base\InputData\InputData;
use Yiisoft\Form\Field\Select;

$inputData = new InputData(
    name: 'SelectForm[number]',
    label: 'Select number',
    id: 'selectform-number',
);
echo Select::widget()
    ->inputData($inputData)
    ->optionsData([
        1 => 'One',
        2 => 'Two',
    ])
    ->render();
```

Result will be:

```html
<div>
    <label for="selectform-number">Select number</label>
    <select id="selectform-number" name="SelectForm[number]">
        <option value="1">One</option>
        <option value="2">Two</option>
    </select>
</div>
```
