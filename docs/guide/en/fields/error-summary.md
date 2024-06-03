# Error Summary Field

Displays a summary of the form validation errors. If there are no validation errors, field will be hidden.

## Usage Example

Widget:

```php
$errors = ['name' => ['Value cannot be blank.'], 'age' => ['Value must be no less than 18.']];
echo ErrorSummary::widget()->errors($errors)->render();
```

Result will be:

```html
<div>
    <ul>
        <li>Value cannot be blank.</li>
        <li>Value must be no less than 18.</li>
    </ul>
</div>
```
