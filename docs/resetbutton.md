# Reset button widget

[ResetButton](https://www.w3.org/TR/2012/WD-html-markup-20120329/input.reset.html#input.reset) is an element with a type attribute whose value is "reset" represents a button for resetting a form.

## Usage

Widget view:

```php
<?php

declare(strict_types=1);

use Yiisoft\Form\Widget\Field;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Form\Widget\ResetButton;

/**
 * @var object $csrf
 */
?>

<?= Form::widget()->action('widgets')->csrf($csrf)->begin(); ?>
    <?= ResetButton::widget()->value('Reset Form'); ?>
    <hr class="mt-3">
    <?= Field::widget()->submitButton(['class' => 'button is-block is-info is-fullwidth', 'value' => 'Save']); ?>
<?= Form::end(); ?>
```

That would generate the following code:

```html
<form action="widgets" method="POST" _csrf="LB8wetUt2ESCosrpbO1wsJEj1UQMxhK9RPyY0wExq9lIckEo50GbJbbT860zgACCy1C-aTWNfs50kcybWELGlQ==">
    <input type="hidden" name="_csrf" value="LB8wetUt2ESCosrpbO1wsJEj1UQMxhK9RPyY0wExq9lIckEo50GbJbbT860zgACCy1C-aTWNfs50kcybWELGlQ==">
    <input type="reset" id="reset-10194484223001" name="reset-10194484223001" value="Reset Form">
    <hr class="mt-3">
    <div>
        <input type="submit" id="submit-10194493875001" class="button is-block is-info is-fullwidth" name="submit-10194493875001" value="Save">
    </div>
</form>
```

### `Common` methods:

Method | Description | Default
-------|-------------|---------
`autoIdPrefix(string $value)` | Sets the prefix for generating automatic IDs | `'reset-'`
`attributes(array $value)` | Sets the HTML attributes | `[]``
`id(string $id)` | Sets the ID attribute | `''`
`name(string $name)` | Sets the name attribute | `''`
`value(string $value)` | Sets the value attribute | `''`
