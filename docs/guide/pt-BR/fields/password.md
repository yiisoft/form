# Campo de senha

Representa o elemento `<input>` do tipo "password" que permite ao usuário inserir uma senha com segurança. Documentação:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#password-state-(type=password))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/password)

## Exemplo de uso

Modelo de formulário:

```php
final class ProfileForm extends FormModel
{
    public ?string $password = null;

    public function getAttributeLabels(): array
    {
        return [
            'password' => 'Enter password',
        ];
    }
}
```

Widget:

```php
echo Password::widget()
    ->formAttribute($profileForm, 'password')
    ->minlength(8);
```

O resultado será:

```html
<div>
    <label for="profileform-password">Enter password</label>
    <input type="password" id="profileform-password" name="ProfileForm[password]" minlength="8">
</div>
```

## Valores suportados

- `string`
- `null`
