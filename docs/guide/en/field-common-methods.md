# Common field methods

- [Field parts](field-common-methods/field-part.md)
  - [Visibility / content](field-common-methods/field-part.md#visibility--content) 
  - [Config](field-common-methods/field-part.md#config)
  - [Attributes](field-common-methods/field-part.md#attributes)
  - [ID](field-common-methods/field-part.md#id)
  - [Class](field-common-methods/field-part.md#class)
- [Templating system](field-common-methods/templating-system.md)
  - [Template](field-common-methods/templating-system.md#template)
  - [Tokens](field-common-methods/templating-system.md#tokens)

- [`containerTag`](#containerTag)
- [`containerAttributes`](#containerattributes)
- [`containerClass`](#containerclass)
- [`useContainer`](#usecontainer)

- [`inputContainerTag`](#inputcontainertag)
- [`inputContainerAttributes`](#inputcontainerattributes)
- [`inputContainerClass`](#inputcontainerclass)

### `containerTag`

HTML tag for outer container that wraps the field.

Usage:

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()->containerTag('span');
```

Result:

```html
<span>
    <input type="text">
</span>
```

When no specified, `div` tag is used.

### `containerAttributes`

HTML attributes for outer container that wraps the field.

Usage:

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()->containerAttributes(['class' => 'field-container']);
```

Result:

```html
<div class="field-container">
    <input type="text">
</div>
```

No attributes are used by default.

### `containerClass`

HTML class for outer container that wraps the field.

Usage:

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()->containerClass('field-container');
```

```html
<div class="field-container">
    <input type="text">
</div>
```

No class is used by default.

### `useContainer`

Whether to use outer container that wraps the field.

To disable container:

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()->useContainer(false);
```

Result:

```html
<input type="text">
```

Enable container (default):

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()->useContainer(true);
```

Result:

```html
<div>
    <input type="text">
</div>
```



### `inputContainerTag`

HTML tag for outer container that wraps the input.

Usage:

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()->inputContainerTag('span');
```

Result:

```html
<div>
    <span><input type="text"></span>
</div>
```

When no specified, no container is used for input.

### `inputContainerAttributes`

HTML attributes for outer container that wraps the input. Input container tag must be specified too in order for 
container to be created.

Usage:

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()
    ->inputContainerTag('span');
    ->inputContainerAttributes(['class' => 'input-container']);
```

Result:

```html
<div>
    <span class="input-container"><input type="text"></span>
</div>
```

When no specified, no attributes is used for input.

### `inputContainerClass`

HTML class for outer container that wraps the input. Input container tag must be specified too in order for container to 
be created.

Usage:

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()->inputContainerClass('input-container');
```

```html
<div>
    <span class="input-container"><input type="text"></span>
</div>
```

No class is used by default.

---

BaseField

- containerId

PartsField

inputContainerTag(tag: null|string): PartsField
inputContainerAttributes(attributes: array): PartsField
addInputContainerAttributes(attributes: array): PartsField
inputContainerClass(...class: null|string): PartsField
addInputContainerClass(...class: null|string): PartsField
beforeInput(content: string|Stringable): PartsField
afterInput(content: string|Stringable): PartsField
