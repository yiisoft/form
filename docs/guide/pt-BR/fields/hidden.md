# Campo oculto

Representa o elemento `<input>` do tipo "hidden" que permite ao desenvolvedor web incluir dados que não devem ser vistos ou modificados
pelos usuários quando um formulário é enviado. Documentação:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#hidden-state-(type=hidden))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/hidden)

## Exemplo de uso

Modelo de formulário:

```php
final class ProfileForm extends FormModel
{
    public string $action = 'update';
}
```

Widget:

```php
echo Hidden::widget()->formAttribute($profileForm, 'action');
```

O resultado será:

```html
<input type="hidden" id="profileform-action" name="ProfileForm[action]" value="update">
```

## Valores suportados

- `string`
- número ou string numérica (veja [is_numeric()](https://www.php.net/manual/pt_BR/function.is-numeric.php))
- `null`
