# Campo DataHora

Representa o elemento `<input>` do tipo "datetime" que permite ao usuário inserir uma data e hora (hora, minuto, segundo e
fração de segundo), bem como um fuso horário. Documentação:

- [HTML 5.2 W3C Candidate Recommendation](https://www.w3.org/TR/2017/CR-html52-20170808/sec-forms.html#date-and-time-state-typedatetime)
- [MDN Web Docs](https://developer.mozilla.org/docs/Web/HTML/Element/input/date)

## Exemplo de uso

Modelo de formulário:

```php
final class CreateForm extends FormModel
{
    public ?string $publishDate = '2017-06-01T08:30';

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
echo DateTime::widget()->formAttribute($createForm, 'publishDate');
```

O resultado será:

```html
<div>
    <label for="createform-publishdate">Publish date</label>
    <input type="datetime" id="createform-publishdate" name="CreateForm[publishDate]" value="2017-06-01T08:30">
    <div>Input publish date of post.</div>
</div>
```

## Valores suportados

- `string`
- `null`
