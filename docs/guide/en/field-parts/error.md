# Error Field Part

Represent a field validation error (if there are several errors, the first one is used). If field has no validation
error, this field part will be hidden.

## Usage Example

Form model:

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

Prepare and validate form model:

```php
$profileForm = new ProfileForm();
$profileForm->age = 17;
(new Validator())->validate($profileForm);
```

Widget:

```php
echo Error::widget()->formAttribute($profileForm, 'age');
```

Result will be:

```html
<div>Value must be no less than 18.</div>
```
