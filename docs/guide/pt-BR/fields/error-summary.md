# Campo de resumo de erros

Exibe um resumo dos erros de validação do formulário. Se não houver erro de validação, o campo ficará oculto.

## Exemplo de uso

Modelo de formulário:

```php
final class ProfileForm extends FormModel
{
    public ?string $name = null;
    public ?int $age = null;

    public function getAttributeLabels(): array
    {
        return [
            'name' => 'Name',
            'age' => 'Age',
        ];
    }

    public function getRules(): array
    {
        return [
            'name' => [new Required()],
            'age' => [new Number(asInteger: true, min: 18)],
        ];
    }
}
```

Preparar e validar modelo de formulário:

```php
$profileForm = new ProfileForm();
$profileForm->name = '';
$profileForm->age = 17;
(new Validator())->validate($profileForm);
```

Widget:

```php
echo ErrorSummary::widget()->formModel($profileForm);
```

O resultado será:

```html
<div>
    <p>Please fix the following errors:</p>
    <ul>
        <li>Value cannot be blank.</li>
        <li>Value must be no less than 18.</li>
    </ul>
</div>
```
