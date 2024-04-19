# Fieldset Field

Represents `<fieldset>` element used to group several controls. Documentation:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/form-elements.html#the-fieldset-element)
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/fieldset)

## Usage Example

Widget:

```php
echo Fieldset::widget()->content(
    Field::text($profileForm, 'firstName')->useContainer(false),
    "\n",
    Field::text($profileForm, 'lastName')->useContainer(false),
);
```

or

```php
echo Fieldset::widget()->begin()
    . "\n"
    . Field::text($profileForm, 'firstName')->useContainer(false)
    . "\n"
    . Field::text($profileForm, 'lastName')->useContainer(false)
    . "\n"
    . Fieldset::end()
```

Result will be:

```html
<div>
    <fieldset>
        <label for="profileform-firstname">First name</label>
        <input type="text" id="profileform-firstname" name="ProfileForm[firstName]" value>
        <label for="profileform-lastname">Last name</label>
        <input type="text" id="profileform-lastname" name="ProfileForm[lastName]" value>
    </fieldset>
</div>
```
