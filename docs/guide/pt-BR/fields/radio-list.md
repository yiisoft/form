# Campo da lista de rádio

Representa uma lista de botões de opção tipo rádio com uma única seleção.

## Exemplo de uso

Modelo de formulário:

```php
final class ProfileForm extends FormModel
{
    public string $color = 'red';

    public function getAttributeLabels(): array
    {
        return [
            'color' => 'Select color',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'color' => 'Your personal color.',
        ];
    }
}
```

Widget:

```php
echo RadioList::widget()
    ->formAttribute($profileForm, 'color')
    ->items([
        'f00' => 'Red',
        '0f0' => 'Green',
        '00f' => 'Blue',
    ]);
```

O resultado será:

```html
<div>
    <label>Select color</label>
    <div>
        <label><input type="radio" name="ProfileForm[color]" value="f00" checked> Red</label>
        <label><input type="radio" name="ProfileForm[color]" value="0f0"> Green</label>
        <label><input type="radio" name="ProfileForm[color]" value="00f"> Blue</label>
    </div>
    <div>Your personal color.</div>
</div>
```

## Valores suportados

- `string`
- número ou string numérica (veja [is_numeric()](https://www.php.net/manual/pt_BR/function.is-numeric.php))
- `bool`
- `null`
- quaisquer valores stringáveis