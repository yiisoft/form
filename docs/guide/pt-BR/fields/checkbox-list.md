# Campo da lista de caixas de seleção

Representa uma lista de caixas de seleção com seleção múltipla.

## Exemplo de uso

Modelo de formulário:

```php
final class ProfileForm extends FormModel
{
    public array $color = ['red'];

    public function getAttributeLabels(): array
    {
        return [
            'color' => 'Select one or more colors',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'color' => 'Your personal color(s).',
        ];
    }
}
```

Widget:

```php
echo CheckboxList::widget()
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
    <label>Select one or more colors</label>
    <div>
        <label><input type="checkbox" name="ProfileForm[color][]" value="f00" checked> Red</label>
        <label><input type="checkbox" name="ProfileForm[color][]" value="0f0"> Green</label>
        <label><input type="checkbox" name="ProfileForm[color][]" value="00f"> Blue</label>
    </div>
    <div>Your personal color(s).</div>
</div>
```

## Valores suportados

O campo requer valor iterável ou `null`.