# Time Field

Represents `<input>` element of type "time" that lets the user enter a time, either with a textbox that validates the 
input or with a special time picker interface. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#time-state-(type=time))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/time)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\Time;

echo Time::widget()->render();
```

Result will be:

```html
<div>
    <input type="time">
</div>
```
