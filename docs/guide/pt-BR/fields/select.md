# Selecione o campo

Representa o elemento `<select>` que fornece um menu de opções. Documentação:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/form-elements.html#the-select-element)
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/select)

## Exemplo de uso

Modelo de formulário:

```php
final class ProfileForm extends FormModel
{
    public ?string $color = 'f00';

    public function getAttributeLabels(): array
    {
        return [
            'color' => 'Select color',
        ];
    }
}
```

Widget:

```php
echo Select::widget()
    ->formAttribute($profileForm, 'color')
    ->optionsData([
        'f00' => 'Red',
        '0f0' => 'Green',
        '00f' => 'Blue',
    ]);
```

O resultado será:

```html
<div>
    <label for="profileform-color">Select color</label>
    <select id="profileform-color" name="ProfileForm[color]">
        <option value="f00">Red</option>
        <option value="0f0">Green</option>
        <option value="00f">Blue</option>
    </select>
</div>
```

## Valores suportados

- `string`
- número ou string numérica (veja [is_numeric()](https://www.php.net/manual/pt_BR/function.is-numeric.php))
- `bool`
- `null`
- quaisquer valores stringáveis

A seleção múltipla requer valor iterável ou `null`.
