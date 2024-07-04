# Campo botão

Representa o elemento `<button>` do tipo "botão". É renderizado como botão sem comportamento padrão. Documentação:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/form-elements.html#attr-button-type-button-state)
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/button)

## Exemplo de uso

Widget:

```php
echo Button::widget()->content('Click Me');
```

O resultado será:

```html
<div>
    <button type="button">Click Me</button>
</div>
```
