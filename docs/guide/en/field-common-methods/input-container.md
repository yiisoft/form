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

When no specified, no container is used for input.

## Attributes

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

## Class

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
When no specified, no class is used for input.
