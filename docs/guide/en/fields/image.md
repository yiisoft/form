# Image Field

Represents `<input>` element of type "image" that is used to create graphical submit buttons. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#image-button-state-(type=image))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/image)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\Image;

echo Image::widget()
    ->src('btn.png')
    ->alt('Go');
```

Result will be:

```html
<div>
    <input type="image" src="btn.png" alt="Go">
</div>
```
