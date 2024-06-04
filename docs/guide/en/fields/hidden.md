# Hidden Field

Represents `<input>` element of type "hidden" that lets web developer to include data that shouldn't be seen or modified
by users when a form is submitted. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#hidden-state-(type=hidden))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/hidden)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\Hidden;

echo Hidden::widget()
    ->name('key')
    ->value('x100')
    ->inputId('hiddenform-key');
```

Result will be:

```html
<input type="hidden" id="hiddenform-key" name="key" value="x100">
```
