# Campo numérico

Representa o elemento `<input>` do tipo "number" que permite ao usuário inserir um número. Documentação:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#number-state-(type=number))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/number)

## Exemplo de uso

Modelo de formulário:

```php
final class ProfileForm extends FormModel
{
    public ?int $age = null;

    public function getAttributeLabels(): array
    {
        return [
            'age' => 'Your age',
        ];
    }
}
```

Widget:

```php
echo Number::widget()
    ->formAttribute($profileForm, 'age')
    ->min(21)
    ->max(150);
```

O resultado será:

```html
<div>
    <label for="profileform-age">Your age</label>
    <input type="number" id="profileform-age" name="ProfileForm[age]" min="21" max="150">
</div>
```

## Valores suportados

- número ou string numérica (veja [is_numeric()](https://www.php.net/manual/pt_BR/function.is-numeric.php))
- `null`