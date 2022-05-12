# Submit Button Field

Represents `<button>` element of type "submit" are rendered as button for submitting a form. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/form-elements.html#attr-button-type-submit-state)
- [MDN Web Docs](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/button)

## Usage Example

Widget:

```php
echo SubmitButton::widget()->content('Send');
```

Result will be:

```html
<div>
    <button type="submit">Send</button>
</div>
```
