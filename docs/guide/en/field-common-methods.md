# Common field methods

- [Container](field-common-methods/container.md)
  - [Tag](field-common-methods/container.md#tag)
  - [Attributes](field-common-methods/container.md#attributes)
  - [ID](field-common-methods/container.md#id)
  - [class](field-common-methods/container.md#class)
  - [Inclusion / exclusion](field-common-methods/container.md#inclusion--exclusion)
- [Field parts](field-common-methods/field-part.md)
  - [Visibility / content](field-common-methods/field-part.md#visibility--content) 
  - [Config](field-common-methods/field-part.md#config)
  - [Attributes](field-common-methods/field-part.md#attributes)
  - [ID](field-common-methods/field-part.md#id)
  - [Class](field-common-methods/field-part.md#class)
- [Templating system](field-common-methods/templating-system.md)
  - [Template](field-common-methods/templating-system.md#template)
  - [Tokens](field-common-methods/templating-system.md#tokens)

- [`inputContainerTag`](#inputcontainertag)
- [`inputContainerAttributes`](#inputcontainerattributes)
- [`inputContainerClass`](#inputcontainerclass)

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


PartsField

inputContainerTag(tag: null|string): PartsField

inputContainerAttributes(attributes: array): PartsField
addInputContainerAttributes(attributes: array): PartsField

inputContainerClass(...class: null|string): PartsField
addInputContainerClass(...class: null|string): PartsField

beforeInput(content: string|Stringable): PartsField
afterInput(content: string|Stringable): PartsField
