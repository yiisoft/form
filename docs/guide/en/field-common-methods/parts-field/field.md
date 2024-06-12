# Parts field

Parts field consists of 4 elements:

- Label;
- Hint;
- Input;
- Error.

Input here can be composite and can contain multiple elements.

## Visibility / content

By default, neither of field parts are shown. To show them, call self-titled methods:

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()
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

Another way is to use [config](#config).

For the label, there is additional method to control its visibility. It can be hidden:

```php
use Yiisoft\Form\Field\Text;

$field = Text::widget();

/** @var bool $condition */
if ($condition) {
    $field = $field->hideLabel();
}

$field = $field->label('Name')

echo $field;
```

> The order of method calls is not important.

To show it:

```php
use Yiisoft\Form\Field\Text;

$field = Text::widget();

/** @var bool $condition */
if ($condition) {
    $field = $field->hideLabel(false);
}

$field = $field->label('Name')

echo $field;
```

## Config

Config with [definitions](https://github.com/yiisoft/definitions) for field part.

Usage:

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()
    ->labelConfig(['content()' => ['Name'], 'class()' => ['label']])
    ->hintConfig(['content()' => ['Enter name'], 'class()' => ['hint']])
    ->errorConfig(['message()' => ['Name is not valid.'], 'class()' => ['error']]);
```

Result:

```html
<div>
    <label class="label">Name</label>
    <input type="text">
    <div class="hint">Enter name</div>
    <div class="error">Name is not valid.</div>
</div>
```

## Attributes

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

> The field part must be visible (use [visibility / content](#visibility--content) methods or set content with
> [config](#config)).

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

Note that values within the same attribute will not be merged, newly added value overrides previous one:

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

## ID

HTML ID for field part.

Usage:

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()
    ->label('Name')
    ->labelId('label')
    ->hint('Enter name')
    ->hintId('hint')
    ->error('Name is not valid.')
    ->errorId('error');
```

> The field part must be visible (use [visibility / content](#visibility--content) methods or set content with
> [config](#config)).

Result:

```html
<div>
    <label id="label">Name</label>
    <input type="text">
    <div id="hint">Enter name</div>
    <div id="error">Name is not valid.</div>
</div>
```

## Class

HTML class for field part.

Usage:

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()
    ->label('Name')
    ->labelClass('label')
    ->hint('Enter name')
    ->hintClass('hint')
    ->error('Name is not valid.')
    ->errorClass('error');
```

> The field part must be visible (use [visibility / content](#visibility--content) methods or set content with
> [config](#config)).

Result:

```html
<div>
    <label class="label">Name</label>
    <input type="text">
    <div class="hint">Enter name</div>
    <div class="error">Name is not valid.</div>
</div>
```

To add classes to the existing ones:

```php
use Yiisoft\Form\Field\Text;

$field = Text::widget()
    ->label('Name')
    ->labelClass('label')
    ->hint('Enter name')
    ->hintClass('hint')
    ->error('Name is not valid.')
    ->errorClass('error');

/** @var $condition bool */
if ($condition) {
    $field = $field
        ->addLabelClass('info')
        ->addHintClass('info')
        ->addErrorClass('info');
}

echo $field;
```

> The field part must be visible (use [visibility / content](#visibility--content) methods or set content with
> [config](#config)).

Result:

```html
<div>
    <label class="label info">Name</label>
    <input type="text">
    <div class="hint info">Enter name</div>
    <div class="error info">Name is not valid.</div>
</div>
```

For multiple classes, separate them with space:

```php
use Yiisoft\Form\Field\Text;

$field = Text::widget()
    ->label('Name')
    ->labelClass('label')
    ->hint('Enter name')
    ->hintClass('hint')
    ->error('Name is not valid.')
    ->errorClass('error');

/** @var $condition bool */
if ($condition) {
    $field = $field
        ->addLabelClass('info theme')
        ->addHintClass('info theme')
        ->addErrorClass('info theme');
}
```

Result:

```html
<div>
    <label class="label info theme">Name</label>
    <input type="text">
    <div class="hint info theme">Enter name</div>
    <div class="error info theme">Name is not valid.</div>
</div>
```
