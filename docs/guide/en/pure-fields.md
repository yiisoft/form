# Pure fields

To ease the creation of the fields with `\Yiisoft\Form\Field\Base\InputData\PureInputData` as a data source, use
corresponding helper (`\Yiisoft\Form\PureField`):

```php
use Yiisoft\Form\PureField;

$field = PureField::text('name', 'value');
```

or factory (`\Yiisoft\Form\PureFieldFactory`):

```php
use Yiisoft\Form\PureFieldFactory;

$factory = new PureFieldFactory();
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

To additionally apply theme, either pass it as argument (supported by factory):

```php
use Yiisoft\Form\PureFieldFactory;

$factory = new PureFieldFactory('my-theme');
$factory->text('name', 'value');
```

or override the theme property via class inheritance (supported by helper):

```php
use Yiisoft\Form\PureField;

final class ThemedPureField extends PureField
{
    protected const DEFAULT_THEME = 'default';
}
```
