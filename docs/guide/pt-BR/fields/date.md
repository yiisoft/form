# Campo de data

Representa o elemento `<input>` do tipo "date" que permite ao usuário inserir uma data, seja com uma caixa de texto que valida
a entrada ou com uma interface especial de seleção de data. Documentação:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#date-state-(type=date))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/date)

## Exemplo de uso

Modelo de formulário:

```php
final class CreateForm extends FormModel
{
    public ?string $publishDate = null;

    public function getAttributeLabels(): array
    {
        return [
            'name' => 'Publish date',
        ];
    }

    public function getAttributeHints(): array
    {
        return [
            'name' => 'Input publish date of post.',
        ];
    }
}
```

Widget:

```php
echo Date::widget()
    ->formAttribute($createForm, 'publishDate')
    ->min('2022-01-01')
    ->max('2038-12-31');
```

O resultado será:

```html
<div>
    <label for="createform-publishdate">Publish date</label>
    <input type="date" id="createform-publishdate" name="CreateForm[publishDate]" min="2022-01-01" max="2038-12-31">
    <div>Input publish date of post.</div>
</div>
```

## Valores suportados

- `string`
- `null`