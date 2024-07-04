# Campo do conjunto de campos

Representa o elemento `<fieldset>` usado para agrupar vários controles. Documentação:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/form-elements.html#the-fieldset-element)
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/fieldset)

## Exemplo de uso

Widget:

```php
echo Fieldset::widget()->content(
    Field::text($profileForm, 'firstName')->useContainer(false),
    "\n",
    Field::text($profileForm, 'lastName')->useContainer(false),
);
```

ou

```php
echo Fieldset::widget()->begin()
    . "\n"
    . Field::text($profileForm, 'firstName')->useContainer(false)
    . "\n"
    . Field::text($profileForm, 'lastName')->useContainer(false)
    . "\n"
    . Fieldset::end()
```

O resultado será:

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
