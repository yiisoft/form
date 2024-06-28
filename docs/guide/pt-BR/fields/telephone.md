# Campo de telefone

Representa o elemento `<input>` do tipo "tel" que permite ao usuário inserir e editar um número de telefone. Documentação:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#telephone-state-(type=tel))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/tel)

## Exemplo de uso

Modelo de formulário:

```php
final class ProfileForm extends FormModel
{
    public ?string $phone = null;

    public function getAttributeLabels(): array
    {
        return [
            'phone' => 'Your phone number',
        ];
    }
}
```

Widget:

```php
echo Telephone::widget()
    ->formAttribute($profileForm, 'phone')
    ->pattern('[0-9]{3}-[0-9]{3}-[0-9]{4}');
```

O resultado será:

```html
<div>
    <label for="profileform-phone">Your phone number</label>
    <input type="tel" id="profileform-phone" name="ProfileForm[phone]" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
</div>
```

## Valores suportados

- `string`
- `null`
