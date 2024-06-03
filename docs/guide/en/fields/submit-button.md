# Submit Button Field

Represents `<button>` element of type "submit" that is rendered as button for submitting a form. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/form-elements.html#attr-button-type-submit-state)
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/button)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\SubmitButton;

echo SubmitButton::widget()
    ->content('Go!')
    ->render();
```

Result will be:

```html
<div>
    <button type="submit">Go!</button>
</div>
```
