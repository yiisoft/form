# Field part

Field part is a component that a field consists of. There are 3 of them:

- Label;
- Hint;
- Error.

## Visibility / content

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

Note that values within the same attribute will not be merged, newly added overrides previous ones:

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
