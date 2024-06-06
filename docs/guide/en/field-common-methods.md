# Common field methods

- [`containerTag`](#containerTag)
- [`containerAttributes`](#containerattributes)
- [`containerClass`](#containerclass)
- [`useContainer`](#usecontainer)
- [`template`](#template)
- [`templateBegin` / `templateEnd`](#templatebegin--templateend)
- [`inputContainerTag`](#inputcontainertag)
- [`inputContainerAttributes`](#inputcontainerattributes)

## `containerTag`

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

## `containerAttributes`

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

## `containerClass`

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

## `useContainer`

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

## `template`

A template for a field where placeholders are field parts. This template is used when field is created using `widget()` 
method.

Supported placeholders:

- `{label}`;
- `{hint}`;
- `{input}`;
- `{error}`.

Defaults to `{label}\n{input}\n{hint}\n{error}`.

Example, changing hint's position:

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()
    ->template("{label}\n{hint}\n{input}\n{error}")
    ->label('Name')
    ->hint('Enter name')
    _>error('Name is not valid.');
```

Result:

```html
<div>
    <label>Name</label>
    <div>Enter name</div>
    <input type="text">
    <div>Name is not valid.</div>
</div>
```

## `templateBegin` / `templateEnd`

Template for a field where placeholders are field parts. These templates are used when field is created using `begin()`
and `end()` methods.

Defaults:

- `templateBegin()`: `{label}\n{input}`;
- `templateEnd()`: `{input}\n{hint}\n{error}`;

Note that `templateBegin()` ends with `{input}` placeholder, while `templateEnd()` starts with it.

Example, changing hint's position:

```php
use Yiisoft\Form\Field\Fieldset;
use Yiisoft\Form\Field\Text;

echo Fieldset::widget()
    ->templateBegin("{label}\n{hint}\n{input}")
    ->templateEnd("{input}\n{error}")
    ->label('Name')
    ->hint('Enter name')
    ->error('Name is not valid.')
    ->begin()
    . "\n"
    . Text::widget()->name('firstName')->useContainer(false)
    . "\n"
    . Text::widget()->name('lastName')->useContainer(false)
    . "\n"
    . Fieldset::end();
```

```html
<div>
    <label>Name</label>
    <div>Enter name</div>
    <fieldset>
        <input type="text" name="firstName">
        <input type="text" name="lastName">
    </fieldset>
    <div>Name is not valid.</div>
</div>
```

## `inputContainerTag`

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

## `inputContainerAttributes`

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

---

BaseField

- containerId

PartsField

tokens(tokens: array): PartsField
token(token: string, value: string|Stringable): PartsField


hideLabel([hide: bool|null = true]): PartsField
inputContainerTag(tag: null|string): PartsField
inputContainerAttributes(attributes: array): PartsField
addInputContainerAttributes(attributes: array): PartsField
inputContainerClass(...class: null|string): PartsField
addInputContainerClass(...class: null|string): PartsField
beforeInput(content: string|Stringable): PartsField
afterInput(content: string|Stringable): PartsField

labelConfig(config: array): PartsField
labelAttributes(attributes: array): PartsField
addLabelAttributes(attributes: array): PartsField
labelId(id: null|string): PartsField
labelClass(...class: null|string): PartsField
addLabelClass(...class: null|string): PartsField
label(content: null|string): PartsField

hintConfig(config: array): PartsField
hintAttributes(attributes: array): PartsField
addHintAttributes(attributes: array): PartsField
hintId(id: null|string): PartsField
hintClass(...class: null|string): PartsField
addHintClass(...class: null|string): PartsField
hint(content: null|string): PartsField

errorConfig(config: array): PartsField
errorAttributes(attributes: array): PartsField
addErrorAttributes(attributes: array): PartsField
errorId(id: null|string): PartsField
errorClass(...class: null|string): PartsField
addErrorClass(...class: null|string): PartsField
error(message: null|string, ...messages: string): PartsField
