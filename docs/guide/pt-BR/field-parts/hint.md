# Parte do campo de dica (hints)

Representa uma dica para um campo de formulário. Se a dica estiver vazia, a parte do campo ficará oculta.

## Exemplo de uso

Modelo de formulário:

```php
final class CreateForm extends FormModel
{
    public ?string $name = null;

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
echo Hint::widget()->formAttribute($createForm, 'name');
```

O resultado será:

```html
<div>Input your full name.</div>
```
