# Form field themes

Themes are used to customize fields' appearance. They can be applied both for individual fields and field sets.

## Theme configuration

```php
return [
    'template' => "{label}\n<div class=\"col-sm-10\">{input}\n{hint}\n{error}</div>",
    'containerClass' => 'mb-3 row',
    'labelClass' => 'col-sm-2 col-form-label',
    'inputClass' => 'form-control',
    'hintClass' => 'form-text',
    'errorClass' => 'invalid-feedback',
    'inputValidClass' => 'is-valid',
    'inputInvalidClass' => 'is-invalid',
    'fieldConfigs' => [
        Checkbox::class => [
            'inputContainerTag()' => ['div'],
            'addInputContainerClass()' => ['form-check'],
            'inputClass()' => ['form-check-input'],
            'inputLabelClass()' => ['form-check-label'],
        ],
    ],
];
```

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

## `ThemePath` usage

## Built-in themes

These themes are available out of the box:

- Bootstrap 5 Horizontal,
- Bootstrap 5 Vertical.

## Themes preview
