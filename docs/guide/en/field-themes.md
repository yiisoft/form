# Form field themes

ThemeContainer configuration, ThemePath usage, built-in themes


Configure themes (optional):

```php
use Yiisoft\Form\Theme\ThemeContainer;
use Yiisoft\Form\Theme\ThemePath;

ThemeContainer::initialize(
    config: [
        'vertical' => require ThemePath::BOOTSTRAP5_VERTICAL,
        'horizontal' => require ThemePath::BOOTSTRAP5_HORIZONTAL,
    ],
    defaultConfig: 'vertical',
);
```

Two themes are available out of the box:

- Bootstrap 5 Horizontal,
- Bootstrap 5 Vertical.

TODO: describe `themes-preview`
