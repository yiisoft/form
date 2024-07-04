# Campo do botão Enviar

Representa o elemento `<button>` do tipo "submit" que é renderizado como botão para enviar um formulário. Documentação:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/form-elements.html#attr-button-type-submit-state)
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/button)

## Exemplo de uso

Widget:

```php
echo SubmitButton::widget()->content('Send');
```

O resultado será:

```html
<div>
    <button type="submit">Send</button>
</div>
```
