# Campo do botão Redefinir

Representa o elemento `<button>` do tipo "reset" que é renderizado como um botão redefinindo todos os controles para seus valores iniciais.
Documentação:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/form-elements.html#attr-button-type-reset-state)
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/button)

## Exemplo de uso

Widget:

```php
echo ResetButton::widget()->content('Reset Form');
```

O resultado será:

```html
<div>
    <button type="reset">Reset Form</button>
</div>
```
