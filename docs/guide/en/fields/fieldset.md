# Fieldset Field

Represents `<fieldset>` element used to group several controls. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/form-elements.html#the-fieldset-element)
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/fieldset)

## Usage Example

Widget:

```php
use Yiisoft\Form\Field\Fieldset;
use Yiisoft\Form\Field\Text;

echo Fieldset::widget()->begin()
. "\n"
. Text::widget()->name('firstName')->useContainer(false),
. "\n"
. Text::widget()->name('lastName')->useContainer(false),
. "\n"
. Fieldset::end();
```

or

```php
use Yiisoft\Form\Field\Fieldset;
use Yiisoft\Form\Field\Text;

echo Fieldset::widget()
    ->content(
        Text::widget()->name('firstName')->useContainer(false),
        . "\n"
        . Text::widget()->name('lastName')->useContainer(false),
    );
```

Result will be:

```html
<div>
    <fieldset>
        <input type="text" name="firstName" value>
        <input type="text" name="lastName" value>
    </fieldset>
</div>
```
