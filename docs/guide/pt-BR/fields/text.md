# Campo de texto

Representa o elemento `<input>` do tipo "text" que cria campos de texto básicos de linha única. Documentação:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#text-(type=text)-state-and-search-state-(type=search))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/text)

## Exemplo de uso

Modelo de formulário:

```php
final class CreateForm extends FormModel
{
    public ?string $name = null;

    public function getAttributeLabels(): array
    {
        return [
            'name' => 'Full Name',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'name' => 'Input your full name.',
        ];
    }
}
```

Widget:

```php
echo Text::widget()
    ->formAttribute($createForm, 'name')
    ->required();
```

O resultado será:

```html
<div>
    <label for="createform-name">Full Name</label>
    <input type="text" id="createform-name" name="CreateForm[name]" required>
    <div>Input your full name.</div>
</div>
```

## Valores suportados

- `string`
- `null`
