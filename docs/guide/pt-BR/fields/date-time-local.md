# Campo DateTimeLocal

Representa o elemento `<input>` do tipo "datetime-local" que permite ao usuário inserir facilmente uma data e uma hora, incluindo
o ano, mês e dia, bem como a hora em horas e minutos. Documentação:

- [HTML Living Standard](https://html.spec.whatwg.org/multipage/input.html#local-date-and-time-state-(type=datetime-local))
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/datetime-local)

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
echo DateTimeLocal::widget()
    ->formAttribute($createForm, 'publishDate')
    ->min('2022-01-01T00:00')
    ->max('2038-12-31T19:30');
```

O resultado será:

```html
<div>
    <label for="createform-publishdate">Publish date</label>
    <input type="datetime-local" id="createform-publishdate" name="CreateForm[publishDate]" min="2022-01-01T00:00" max="2038-12-31T19:30">
    <div>Input publish date of post.</div>
</div>
```

## Valores suportados

- `string`
- `null`