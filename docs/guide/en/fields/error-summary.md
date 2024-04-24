# Error Summary Field

Displays a summary of the form validation errors. If there is no validation error, field will be hidden.

## Usage Example

Form model:

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

Prepare and validate form model:

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

Result will be:

```html
<div>
    <p>Please fix the following errors:</p>
    <ul>
        <li>Value cannot be blank.</li>
        <li>Value must be no less than 18.</li>
    </ul>
</div>
```
