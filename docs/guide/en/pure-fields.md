# Creating fields

To ease the creation of the fields with `\Yiisoft\Form\PureField\InputData` as a data source, use
corresponding helper (`\Yiisoft\Form\PureField\Field`):

```php
use Yiisoft\Form\PureField\Field;

$field = Field::text('name', 'value');
```

or factory (`\Yiisoft\Form\PureField\FieldFactory`):

```php
use Yiisoft\Form\PureField\FieldFactory;

$factory = new FieldFactory();
$factory->text('name', 'value');
```

If you want to customize other properties, such as label, hint, etc., use dedicated methods:

```php
use Yiisoft\Form\Field\Text;

/** @var Text $field */
$field
    ->label('Label')
    ->hint('Hint')
    ->placeholder('Placeholder')
    ->inputId('ID');
```

For more info about input data, see this guide [section](input-data.md).

## Applying theme

To additionally apply theme, you can pass it as argument to a specific field's method (supported by both helper and 
factory):

```php
use Yiisoft\Form\PureField\Field;
use Yiisoft\Form\PureField\FieldFactory;

// Using helper

Field::text('name', 'value', 'my-theme');

// Using factory

$factory = new FieldFactory();
$factory->text('name', 'value');
```

To apply the theme for all fields, either pass it as argument in constructor (supported by factory).

```php
use Yiisoft\Form\PureField\FieldFactory;

$factory = new FieldFactory('my-theme');
$factory->text('name', 'value');
```

or override the theme property via class inheritance (supported by helper):

```php
use Yiisoft\Form\PureField\Field;

final class ThemedField extends Field
{
    protected const DEFAULT_THEME = 'default';
}
```

and use this class instead:

```php
ThemedField::text('name', 'value');
```

Which one to choose depends on the situation, but factory has some advantages:

- It's more convenient to use when multiple themes are used simultaneously. The static helper requires separate file / 
class per each theme.
- It can be passed and injected between classes as a dependency more explicitly.

## Counterparts in other packages

[Yii Form Model](https://github.com/yiisoft/form-model) has similar helper `Field` which uses own `InputData` 
implementation (which receives data from form model).
