# Label Field Part

Represents label for a form field. If label is empty, field part will be hidden.

## Usage Example

Form model:

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
echo Label::widget()->attribute($createForm, 'name');
```

Result will be:

```html
<label for="createform-name">Full Name</label>
```
