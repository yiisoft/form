# Campo de intervalo

Representa o elemento `<input>` do tipo "range" que permite ao usuário especificar um valor numérico que não deve ser menor que um determinado
valor e não mais do que outro valor determinado. Documentação:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#range-state-(type=range))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/range)

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
    <input type="range" id="profileform-age" name="ProfileForm[age]" min="21" max="150">
</div>
```

## Valores suportados

- `string`
- número ou string numérica (veja [is_numeric()](https://www.php.net/manual/pt_BR/function.is-numeric.php))
- `null`