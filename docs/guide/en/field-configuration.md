# Field configuration

Because all fields are extended from `Yiisoft\Widget\Widget` from [Yii Widget](https://github.com/yiisoft/widget) 
package, all widget configuration ways are suitable for form fields as well. They are described in 
[Configuring the widget](https://github.com/yiisoft/widget/blob/master/docs/guide/en/widget-configuring.md) guide 
section.

Besides that, there are some additional configuration options that are specific to fields.

## Theme

This package defines `Yiisoft\Form\Theme\Theme` as a following set of configuration:

- [`containerTag`](field-methods.md#containertag) - HTML tag for outer container that wraps the field.
- [`containerAttributes`](field-methods.md#containerattributes--addcontainerattributes) - HTML attributes for outer 
container that wraps the field.
- [`containerClass`](field-methods.md#containerclass--addcontainerclass) - HTML class for outer container that wraps 
the field.
- [`useContainer`](field-methods.md#usecontainer) - whether to use outer container that wraps the field.
- [`template`](field-methods.md#template) - a template for a field where tokens (placeholders) are field parts. This 
template is used when field is rendered.
- [`templateBegin`](field-methods.md#templatebegin--templateend) - starting template for the case when field is created 
using `begin()` and `end()` methods.
- [`templateEnd`](field-methods.md#templatebegin--templateend) - ending template for the case when field is created
using `begin()` and `end()` methods.
- [`shouldSetInputId`](field-methods.md#shouldsetinputid) - whether HTML ID for input should be set.
- [`inputAttributes`](field-methods.md#inputattributes--addinputattributes) - HTML attributes for input.
- [`inputClass`](field-methods.md#inputclass--addinputclass) - HTML class for input.
- [`inputContainerTag`](field-methods.md#inputcontainertag) - HTML tag for outer container that wraps the input.
- [`inputContainerAttributes`](field-methods.md#inputcontainerattributes--addinputcontainerattributes) - HTML attributes
for outer container that wraps the input.
- [`inputContainerClass`](field-methods.md#inputcontainerclass--addinputcontainerclass) - HTML class for outer container
that wraps the input.
- [`labelClass`](field-methods.md#labelclass--addlabelclass) - HTML class for label.
- [`labelConfig`](field-methods.md#labelconfig) - Config with [definitions](https://github.com/yiisoft/definitions) for `Label` widget.
- [`hintClass`](field-methods.md#hintclass--addhintclass) - HTML class for hint.
- [`hintConfig`](field-methods.md#hintconfig) - config with [definitions](https://github.com/yiisoft/definitions) for `Hint` widget.
- [`errorClass`](field-methods.md#errorclass--adderrorclass) - HTML class for error.
- [`errorConfig`](field-methods.md#errorconfig) - config with [definitions](https://github.com/yiisoft/definitions) for `Error` widget.
- [`usePlaceholder`](field-methods.md#useplaceholder) - whether to use placeholder - the example value intended to help
user fill the actual value.
- [`validClass`](field-methods.md#validclass) - HTML class for the field container when the field has been validated and
has no validation errors.
- [`invalidClass`](field-methods.md#invalidclass) - HTML class for the field container when the field has been validated
and has validation errors. 
- [`inputValidClass`](field-methods.md#inputvalidclass) - HTML class for the input when the field has been validated and
- has no validation errors.
- [`inputInvalidClass`](field-methods.md#inputinvalidclass) - HTML class for the input when the field has been validated
and has validation errors.
- [`enrichFromValidationRules`](field-methods.md#enrichfromvalidationrules) - whether to 
[enrich](validation-rules-enrichment.md) this field from validation rules.
- [`validationRulesEnricher`](field-methods.md#validationrulesenricher) - 
[validation rules enricher](validation-rules-enrichment.md) instance.
- `fieldConfigs` - configuration sets by field type declared using [definitions](https://github.com/yiisoft/definitions)
syntax.

All settings are optional.

## Theme container

Theme container is used to register themes. Call `initialize()` method before using any field with `$configs` argument,
where:

- key is a theme name;
- value is a mapping (associative array) between [settings'](#theme) names and their corresponding values.

```php
use Yiisoft\Form\Theme\ThemeContainer;

ThemeContainer::initialize(
    configs: [
        'main' => [ 
            'containerClass' => 'field-container-main',
            // ...            
            'fieldConfigs' => [
                Checkbox::class => [
                    'inputContainerTag()' => ['div'],
                    // ...
                ],
                // ...
            ],
        ],
        'alternative' => [
            'containerClass' => 'field-container-alt',
            // ...            
            'fieldConfigs' => [
                Checkbox::class => [
                    'inputContainerTag()' => ['span'],
                    // ...
                ],
                // ...
            ],
        ],      
    ],
    defaultConfig: 'main',
    validationRulesEnricher: new MyValidationRulesEnricher(),
);
```

You can additionally set (optional):

- config used as a default one using `defaultConfig` option;
- [enricher](validation-rules-enrichment.md) instance used to enrich fields depending on their type from given 
validation rules.

## Built-in themes

These themes are available out of the box:

- Bootstrap 5 Horizontal;
- Bootstrap 5 Vertical.

Their settings are stored in separate configuration files. To simplify including it, you can use 
`Yiisoft\Form\Theme\ThemePath` - constants with for all built-in themes.

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

## Using with Yii Config

When using [Yii Config](https://github.com/yiisoft/config), there is no need to manually interact with theme cotnainer,
it's initialized automatically during application's bootstrap. Here is an example of relevant `config/params.php` file
section for configuration:

```php
use Yiisoft\Form\Theme\ThemePath;

return [
    // ...
    'yiisoft/form' => [
        'themes' => [
            'vertical' => require ThemePath::BOOTSTRAP5_VERTICAL,
            'horizontal' => require ThemePath::BOOTSTRAP5_HORIZONTAL,
        ],
        'defaultTheme' => 'vertical',
        'validationRulesEnricher' => new MyValidationRulesEnricher(),
    ],
    // ...
];
```

No built-in themes and validation rules enricher are used by default.
