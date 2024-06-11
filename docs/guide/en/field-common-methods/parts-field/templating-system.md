# Templating system

## Template

A template for a field where tokens (placeholders) are field parts. This template is used when field is created using
`widget()` method.

Supported tokens:

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

When field is created using `begin()` and `end()` methods, customization of templates is done via `templateBegin()` and
`templateEnd()` methods.

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

### Content before and after input

There is also a possibility to customize content before and after the input without redefining template and using custom
tokens:

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()
    ->inputContainerTag('span')
    ->beforeInput('before')
    ->afterInput('after');
```

Result:

```html
<div>
    <span>before<input type="text">after</span>
</div>
```

## Tokens

Tokens (placeholders) are field parts in the template. You can register custom tokens like this:

```php
Text::widget()
    // Multiple tokens at once
    ->tokens([
        '{before}' => '<section>',
        '{after}' => '</section>',
    ])
    // One token
    ->token('{icon}', '<span class="icon"></span>')
    ->template("{before}\n{input}\n{icon}\n{after}");
```

Result:

```html
<div>
    <section>
        <span class="icon"></span>
    </section>
</div>
```
