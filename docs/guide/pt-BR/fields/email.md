# Campo de e-mail

Representa o elemento `<input>` do tipo "email" que permite ao usuário inserir e editar um endereço de e-mail, ou, se o 
atributo "múltiplo" for especificado, uma lista de endereços de e-mail será aceita. Documentação:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#email-state-(type=email))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/email)

## Exemplo de uso

Modelo de formulário:

```php
final class ProfileForm extends FormModel
{
    public ?string $email = null;

    public function getAttributeLabels(): array
    {
        return [
            'email' => 'Your e-mail',
        ];
    }
}
```

Widget:

```php
echo Email::widget()
    ->formAttribute($profileForm, 'email')
    ->required();
```

O resultado será:

```html
<div>
    <label for="profileform-email">Your e-mail</label>
    <input type="email" id="profileform-email" name="ProfileForm[email]" required>
</div>
```

## Valores suportados

- `string`
- `null`