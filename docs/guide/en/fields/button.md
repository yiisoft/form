# Button Field

Represents `<button>` element of type "button". It is rendered as button without default behavior. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/form-elements.html#attr-button-type-button-state)
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/button)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\Button;

echo Button::widget()->content('Click Me');
```

Result will be:

```html
<div>
    <button type="button">Click Me</button>
</div>
```
