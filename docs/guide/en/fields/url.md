# Url Field

Represents `<input>` element of type "url" that lets the user enter and edit an URL. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#url-state-(type=url))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/url)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\Url;

echo Url::widget()
    ->name('UrlForm[site]')
    ->value('')
    ->label('Your site')
    ->hint('Enter your site URL.')
    ->inputId('urlform-site');
```

Result will be:

```html
<div>
    <label for="urlform-site">Your site</label>
    <input type="url" id="urlform-site" name="UrlForm[site]" value>
    <div>Enter your site URL.</div>
</div>
```
