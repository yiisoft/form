# Submit button widget

[SubmitButton](https://www.w3.org/TR/2012/WD-html-markup-20120329/input.submit.html) is an element with a type attribute whose value is "submit" represents a button for submitting a form.
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

<?= Form::widget()->action('widgets')->csrf($csrf)->begin(); ?>
    <?= SubmitButton::widget()->attributes(['class' => 'button is-block is-info is-fullwidth'])->value('Save'); ?>
<?= Form::end(); ?>
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
`autoIdPrefix(string $value)` | Sets the prefix for generating automatic IDs | `'reset-'`
`attributes(array $value)` | Sets the HTML attributes | `[]``
`id(string $id)` | Sets the ID attribute | `''`
`name(string $name)` | Sets the name attribute | `''`
`value(string $value)` | Sets the value attribute | `''`
