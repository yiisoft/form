# Hint Field Part

Represents hint for a form field. If hint is empty, field part will be hidden.

## Usage Example

Form model:

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
echo Hint::widget()->attribute($createForm, 'name');
```

Result will be:

```html
<div>Input your full name.</div>
```
