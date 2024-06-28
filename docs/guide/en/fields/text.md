# Text Field

Represents `<input>` element of type "text" which is a basic single-line text field. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#text-(type=text)-state-and-search-state-(type=search))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/text)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()
    ->name('TextForm[name]')
    ->value('')
    ->label('Name')
    ->hint('Input your full name.')
    ->placeholder('Type your name here')
    ->inputId('textform-name');
```

Result will be:

```html
<div>
    <label for="textform-name">Name</label>
    <input type="text" id="textform-name" name="TextForm[name]" value placeholder="Type your name here">
    <div>Input your full name.</div>
</div>
```
