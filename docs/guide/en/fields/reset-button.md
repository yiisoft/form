# Reset Button Field

Represents `<button>` element of type "reset" that is rendered as button resetting all the controls to their initial
values. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/form-elements.html#attr-button-type-reset-state)
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/button)

## Usage Example

Widget:

```php
echo ResetButton::widget()->content('Reset Form');
```

Result will be:

```html
<div>
    <button type="reset">Reset Form</button>
</div>
```
