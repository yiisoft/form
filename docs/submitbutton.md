# Submit button widget

[SubmitButton](https://www.w3.org/TR/2012/WD-html-markup-20120329/input.submit.html) represents a button for submitting a form.

## Usage

Widget view:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\SubmitButton;

/**
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin() ?>
    <?= SubmitButton::widget()->class('button is-block is-info is-fullwidth')->value('Save') ?>
<?= Form::end() ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="LB8wetUt2ESCosrpbO1wsJEj1UQMxhK9RPyY0wExq9lIckEo50GbJbbT860zgACCy1C-aTWNfs50kcybWELGlQ==">
    <input type="hidden" name="_csrf" value="LB8wetUt2ESCosrpbO1wsJEj1UQMxhK9RPyY0wExq9lIckEo50GbJbbT860zgACCy1C-aTWNfs50kcybWELGlQ==">
    <input type="submit" id="submit-10194493875001" class="button is-block is-info is-fullwidth" name="submit-10194493875001" value="Save">
</form>
```

### `Common` methods:

Method | Description | Default
-------|-------------|---------
`autofocus(bool $value = true)` | Set the autofocus attribute | `false`
`attributes(array $attributes = [])` | The HTML attributes for the widget | `[]`
`class(string $class)` | The CSS class for the widget | `''`
`charset(string $value)` | Set the charset attribute | `UTF-8`
`disabled(bool $value = true)` | Set the disabled attribute | `false`
`encode(bool $value)` | Whether content should be HTML-encoded | `true`
`id(string $value)` | Set the id attribute | `''`
`name(string $value)` | Set the name attribute. | `''`
`tabIndex(int $value)` | Set the tabindex attribute | `''`
`title(string $value)` | Set the title attribute | `''`
`value(string $value)` | Set the value attribute | `''`
