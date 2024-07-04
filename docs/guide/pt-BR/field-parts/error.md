# Parte do campo de erro

Representa um erro de validação de campo (se houver vários erros, é utilizado o primeiro). Se o campo não tiver
erros, esta parte do campo ficará oculta.

## Exemplo de uso

Modelo de formulário:

```php
final class ProfileForm extends FormModel
{
    public ?int $age = null;

    public function getRules(): array
    {
        return [
            'age' => [new Number(asInteger: true, min: 18)],
        ];
    }
}
```

Preparar e validar modelo de formulário:

```php
$profileForm = new ProfileForm();
$profileForm->age = 17;
(new Validator())->validate($profileForm);
```

Widget:

```php
echo Error::widget()->formAttribute($profileForm, 'age');
```

O resultado será:

```html
<div>Value must be no less than 18.</div>
```
