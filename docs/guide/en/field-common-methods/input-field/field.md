# Input field

Input field is a parts field with exactly 1 input element.

## Attributes

HTML attributes for input.

Usage:

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()->inputAttributes(['class' => 'input']);
```

Result:

```html
<div>
    <input type="text" class="input">
</div>
```

To add attributes to existing ones:

```php
use Yiisoft\Form\Field\Text;

$field = Text::widget()->inputAttributes(['class' => 'input']);
    
/** @var $condition bool */
if ($condition) {
    $field = $field->addInputAttributes(['data-type' => 'name']);
}

echo $field;
```

Result:

```html
<div>
    <input type="text" class="input" data-type="name">
</div>
```

Note that values within the same attribute will not be merged, newly added value overrides previous one:

```php
use Yiisoft\Form\Field\Text;

$field = Text::widget()->inputAttributes(['class' => 'input'])

/** @var $condition bool */
if ($condition) {
    $field = $field->addInputAttributes(['class' => 'focus'])
}

echo $field;
```

Result:

```html
<div>
    <label class="focus">Name</label>
    <input type="text">
    <div class="focus">Enter name</div>
    <div class="focus">Name is not valid.</div>
</div>
```

## ID

HTML ID for input.

Usage:

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()->inputId('input');
```

Result:

```html
<div>
    <input type="text" id="input">
</div>
```

No ID is used by default.

There is an additional method to control whether ID should be set. It can be disabled:

```php
use Yiisoft\Form\Field\Text;

$field = Text::widget();

/** @var bool $condition */
if ($condition) {
    $field = $field->setInputId(false);
}

$field = $field->inputId('input')

echo $field;
```

> The order of method calls is not important.

To enable it:

```php
use Yiisoft\Form\Field\Text;

$field = Text::widget();

/** @var bool $condition */
if ($condition) {
    $field = $field->setInputId();
}

$field = $field->inputId('input')

echo $field;
```

## Class

HTML class for input.

Usage:

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()->inputClass('input');
```

Result:

```html
<div>
    <input type="text" class="input">
</div>
```

To add classes to the existing ones:

```php
use Yiisoft\Form\Field\Text;

$field = Text::widget()->inputClass('input')

/** @var $condition bool */
if ($condition) {
    $field = $field->addInputClass('focus');
}

echo $field;
```

Result:

```html
<div>
    <input type="text" class="input focus">
</div>
```

For multiple classes, separate them with space:

```php
use Yiisoft\Form\Field\Text;

$field = Text::widget()->inputClass('input');

/** @var $condition bool */
if ($condition) {
    $field = $field->addInputClass('focus info');
}
```

Result:

```html
<div>
    <input type="text" class="input focus info">
</div>
```

## Form

HTML ID for the form this input belongs to.

Usage:

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()->form('contact-form');
```

Result:

```html
<div>
    <input type="text" form="contact-form">
</div>
```
