# Input container

## Tag

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

When not specified, no container is used for input.

## Attributes

HTML attributes for outer container that wraps the input. Input container tag must be specified for
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

When not specified, no attributes are used for input.

To add attributes to the existing ones:

```php
use Yiisoft\Form\Field\Text;

$field = Text::widget()
    ->inputContainerTag('span')
    ->inputContainerAttributes(['class' => 'input-container']);
    
/** @var $condition bool */
if ($condition) {
    $field = $field->addInputContainerAttributes(['data-type' => 'name']);       
}

echo $field;
```

Result:

```html
<div>
    <span class="input-container" data-type="name"><input type="text"></span>
</div>
```

Note that values within the same attribute will not be merged, newly added value overrides previous one:

```php
use Yiisoft\Form\Field\Text;

$field = Text::widget()->inputContainerAttributes(['class' => 'input-container']);
    
/** @var $condition bool */
if ($condition) {
    $field = $field->addInputContainerAttributes(['class' => 'focus']);       
}

echo $field;
```

Result:

```html
<div>
    <span class="focus"><input type="text"></span>
</div>
```

## Class

HTML class for outer container that wraps the input. Input container tag must be specified too in order for container to
be created.

Usage:

```php
use Yiisoft\Form\Field\Text;

echo Text::widget()
    ->inputContainerTag('span')
    ->inputContainerClass('input-container');
```

```html
<div>
    <span class="input-container"><input type="text"></span>
</div>
```

When no specified, no class is used for input.

To add classes to the existing ones:

```php
use Yiisoft\Form\Field\Text;

$field = Text::widget()
    ->inputContainerTag('span')
    ->inputContainerClass('input-container');

/** @var $condition bool */
if ($condition) {
    $field = $field->addInputContainerClass('focus');
}

echo $field;
```

Result:

```html
<div>
    <span class="input-container focus"><input type="text"></span>
</div>
```

For multiple classes, separate them with space:

```php
use Yiisoft\Form\Field\Text;

$field = Text::widget()
    ->inputContainerTag('span')
    ->inputContainerClass('input-container');

/** @var $condition bool */
if ($condition) {
    $field = $field->addInputContainerClass('focus info');
}

echo $field;
```

Result:

```html
<div>
    <span class="input-container focus info"><input type="text"></span>
</div>
```
