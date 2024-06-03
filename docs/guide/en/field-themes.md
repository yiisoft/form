# Form field themes

Themes are used to customize fields' appearance. They can be applied both for individual fields and field sets.

## Container configuration

Configure themes (optional):

```php
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Form\ThemePath;

ThemeContainer::initialize(
    config: [
        'vertical' => require ThemePath::BOOTSTRAP5_VERTICAL,
        'horizontal' => require ThemePath::BOOTSTRAP5_HORIZONTAL,
    ],
    defaultConfig: 'vertical',
);
```

These themes are available out of the box:

- Bootstrap 5 Horizontal,
- Bootstrap 5 Vertical.

ThemeContainer configuration, ThemePath usage, built-in themes.

TODO: describe `themes-preview`.
