# Field configuration

Fields could be configured on multiple levels.

- Widget factory configuration:
  - With definitions;
  - With a default theme;
  - With themes and theme specified at field level.
- Widget configuration.

## Widget factory configuration

Widget factory could be used to configure fields. It is handy to use it to set global defaults.

### With definitions

You can use definitions:

```php
use Psr\Container\ContainerInterface;
use Yiisoft\Form\Field\Base\BaseField;
use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Form\Field\Base\PartsField;
use Yiisoft\Form\Field\Text;
use Yiisoft\Widget\Widget;
use Yiisoft\Widget\WidgetFactory;

WidgetFactory::initialize(
    /** @var ContainerInterface $container */
    $container,
    definitions: [        
        Text::class => [
            'containerClass()' => ['field-container']
        ],
    ], 
);
echo Text::widget();
```

Result:

```html
<div class="field-container">
    <input type="text">
</div>
```

### With themes

Themes could be used in case you want to have multiple configuration sets
and the ability to switch from one to another. To apply the theme automatically,
specify it as default theme.

```php
use Psr\Container\ContainerInterface;
use Yiisoft\Form\Field\Text;
use Yiisoft\Widget\WidgetFactory;

WidgetFactory::initialize(
    /** @var ContainerInterface $container */
    $container,
    themes: [
        'valid' => [
            Text::class => [
                'containerClass()' => ['field-container valid'],
            ],
        ],
        'invalid' => [
            Text::class => [
                'containerClass()' => ['field-container invalid']
            ],       
        ],
    ],
    defaultTheme: 'valid',  
);
$field = Text::widget();
```

Result:

```html
<div class="field-container valid">
    <input type="text">
</div>
```

Regardless of default theme set, it's also possible to control theme at specific widget level:

```php
use Yiisoft\Form\Field\Text;

$field = Text::widget(theme: 'invalid');
```

Result:

```html
<div class="field-container invalid">
    <input type="text">
</div>
```

See [yiisoft/widget guide on themes](https://github.com/yiisoft/widget/blob/master/docs/guide/en/themes.md) for more 
details.

Note that there is an additional approach covered in [Field themes](field-themes.md) section.  

## Widget configuration

Config could be also passed through `widget()` call for specific field at the place of usage:

```php
use Yiisoft\Form\Field\Text;

$field = Text::widget(
    config: [
        'containerClass()' => ['field-container'],    
    ],
);
```

## Configuration priority

More specific configuration has more priority:

```php
use Psr\Container\ContainerInterface;
use Yiisoft\Form\Field\Text;
use Yiisoft\Widget\WidgetFactory;

WidgetFactory::initialize(
    /** @var ContainerInterface $container */
    $container,
    definitions: [
        Text::class => [
            'containerClass()' => ['field-container valid'],
        ],        
    ],
);
$field = Text::widget(
    config: [
        'containerClass()' => ['field-container invalid'],    
    ],
);
echo $field;
```

Result:

```html
<div class="field-container invalid">
    <input type="text">
</div>
```
