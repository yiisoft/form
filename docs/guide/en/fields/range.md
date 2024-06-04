# Range Field

Represents `<input>` element of type "range" that lets the user specify a numeric value which must be no less than a 
given value, and no more than another given value. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#range-state-(type=range))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/range)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\Range;

echo Range::widget()
    ->name('RangeForm[volume]')
    ->value(23)
    ->label('Volume level')
    ->inputId('rangeform-volume')
    ->min(1)
    ->max(100);
```

Result will be:

```html
<div>
    <label for="rangeform-volume">Volume level</label>
    <input type="range" id="rangeform-volume" name="RangeForm[volume]" value="23" min="1" max="100">
</div>
```
