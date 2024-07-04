# Parte do campo de etiqueta

Representa o label de um campo de formulário. Se o label estiver vazio, a parte do campo ficará oculta.

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
}
```

Widget:

```php
echo Label::widget()->formAttribute($createForm, 'name');
```

O resultado será:

```html
<label for="createform-name">Full Name</label>
```
