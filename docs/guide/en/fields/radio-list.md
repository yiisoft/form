# Radio List Field

Represents a list of radio buttons with a single selection. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#radio-button-state-(type=radio))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/radio)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\RadioList;

echo RadioList::widget()
    ->items([
        'red' => 'Red',
        'blue' => 'Blue',
    ])
    ->name('RadioListForm[color]')
    ->label('Select color')
    ->hint('Color of box.');
```

Result will be:

```html
<div>
    <label>Select color</label>
    <div>
        <label><input type="radio" name="RadioListForm[color]" value="red"> Red</label>
        <label><input type="radio" name="RadioListForm[color]" value="blue"> Blue</label>
    </div>
    <div>Color of box.</div>
</div>
```
