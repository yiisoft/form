# Common field methods

- [`containerTag`](#containerTag)
- [`containerAttributes`](#containerattributes)
- [`containerClass`](#containerclass)
- [`useContainer`](#usecontainer)
- [`template`](#template)
- [`templateBegin` / `templateEnd`](#templatebegin--templateend)
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

### `template`

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

### `templateBegin` / `templateEnd`

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

## Field part

Field part is a component that a field consists of. There are 3 of them:

- Label;
- Hint;
- Error.

### Visibility / content

By default, neither of field parts are shown. To show them, call self-titled methods:

```php
use Yiisoft\Form\Field\Text;

Text::widget()
    ->label('Name')   
    ->hint('Enter name')
    ->error('Name is not valid.');
```

Result:

```html
<div>
    <label>Name</label>
    <input type="text">
    <div>Enter name</div>
    <div>Name is not valid.</div>
</div>
```

### Attributes

HTML attributes for field part.

Usage:

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()
    ->label('Name')
    ->labelAttributes(['class' => 'label'])
    ->hint('Enter name')
    ->hintAttributes(['class' => 'hint'])
    ->error('Name is not valid.')
    ->errorAttributes(['class' => 'error']);
```

> These methods are used together with [visibility / content] methods.  

Result:

```html
<div>
    <label class="label">Name</label>
    <input type="text">
    <div class="hint">Enter name</div>
    <div class="error">Name is not valid.</div>
</div>
```

To add attributes to the existing ones:

```php
use Yiisoft\Form\Field\Text;

$field = Text::widget()
    ->label('Name')
    ->labelAttributes(['class' => 'label'])
    ->hint('Enter name')
    ->hintAttributes(['class' => 'hint'])
    ->error('Name is not valid.')
    ->errorAttributes(['class' => 'error']);
    
/** @var $condition bool */
if ($condition) {
    $field = $field
        ->addLabelAttributes(['data-type' => 'label'])
        ->addHintAttributes(['data-type' => 'hint'])
        ->addErrorAttributes(['data-type' => 'error']);
}

echo $field;
```

Result:

```html
<div>
    <label class="label" data-type="label">Name</label>
    <input type="text">
    <div class="hint" data-type="hint">Enter name</div>
    <div class="error" data-type="error">Name is not valid.</div>
</div>
```

Note that values within the same attribute will not be merged, newly added overrides previous one:

```php
$field = Text::widget()
    ->label('Name')
    ->labelAttributes(['class' => 'label'])
    ->hint('Enter name')
    ->hintAttributes(['class' => 'hint'])
    ->error('Name is not valid.')
    ->errorAttributes(['class' => 'error']);


/** @var $condition bool */
if ($condition) {
    $field = $field
        ->addLabelAttributes(['class' => 'info'])
        ->addHintAttributes(['class' => 'info'])
        ->addErrorAttributes(['class' => 'info']);
}

echo $field;
```

Result:

```html
<div>
    <label class="info">Name</label>
    <input type="text">
    <div class="info">Enter name</div>
    <div class="info">Name is not valid.</div>
</div>
```

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
labelId(id: null|string): PartsField
labelClass(...class: null|string): PartsField
addLabelClass(...class: null|string): PartsField
label(content: null|string): PartsField

hintConfig(config: array): PartsField
hintId(id: null|string): PartsField
hintClass(...class: null|string): PartsField
addHintClass(...class: null|string): PartsField
hint(content: null|string): PartsField

errorConfig(config: array): PartsField
errorId(id: null|string): PartsField
errorClass(...class: null|string): PartsField
addErrorClass(...class: null|string): PartsField
error(message: null|string, ...messages: string): PartsField
