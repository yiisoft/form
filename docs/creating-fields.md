# Creating and Using Custom Fields

You may create your own fields based on the abstract fields included in the package.

## Creating Field Class

Field class must extend `Yiisoft\Form\Field\Base\BaseField` or one of his children and implement necessary abstract 
methods. 

### Base Classes

- `BaseField` — base class that contains common functionality of fields.
- `PartsField` — class extends `BaseField`. It adds templating functionality and parts of field (label, hint, error).
- `InputField` — class extends `PartsField`. It adds form model support (in most cases, this class is used as a base).
- `ButtonField` — specific class for button fields, extends `PartsField`.
- `DateTimeInputField` — specific class for creating form controls with date and/or time input, extends `InputField`.

Base abstract classes structure:

```mermaid
flowchart BT
  ButtonField  -->  PartsField 
  DateTimeInputField  -->  InputField 
  InputField  -->  PartsField 
  PartsField  -->  BaseField 
```

### Feature Traits

You can use feature traits for your field class.

#### `FormAttributeTrait` 

Adds methods for using form model.

#### `FieldContentTrait`

Adds methods for setting and generating custom field content.

#### `VaidationClassTrait` 

Adds methods for setting valid and invalid CSS classes.

To apply common field configuration when field is created through a field factory, class must implement 
`ValidationClassInterface`.

#### `PlaceholderTrait`

Adds methods for using placeholder. Could be applied to children of `InputField` only. 

To apply common field configuration when field is created through a field factory, class must implement
`PlaceholderInterface`.

#### `EnrichmentFromRulesTrait`

Adds method to set option of enrichment field from form model rules.

To apply common field configuration when field is created through a field factory class must implement
`EnrichmentFromRulesInterface`.

## Field Configuration

Sets base configuration of field via parameter "fieldConfigs" of a field factory. For example:

```php
'fieldConfigs' => [
    MyCustomField::class => [
        'containerTag()' => ['div'],
        'containerAttributes()' => [['class' => 'main-wrapper']],
        'inputAttributes()' => [['data-type' => 'input-text']],
        'customMethod()' => [true],
    ],
],
```

Detailed information about configuration of fields see [here](fields-configuration.md).

## Example of Custom Field

Field class:

```php
use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Html\Html;

final class SuffixInput extends InputField
{
    private ?string $suffix = null;

    public function suffix(?string $suffix): self
    {
        $new = clone $this;
        $new->suffix = $suffix;
        return $new;
    }

    protected function generateInput(): string
    {
        $input = Html::textInput(
            $this->getInputName(),
            (string) $this->getFormAttributeValue(),
            $this->getInputAttributes()
        )->render();

        if ($this->suffix === null) {
            $html = $input;
        } else {
            $html = '<div class="input-group">' . "\n";
            $html .= $input . "\n";
            $html .= '<span class="input-group-text">' . Html::encode($this->suffix) . '</span>' . "\n";
            $html .= '</div>';
        }

        return $html;
    }
}
```

Usage is the following:

```php
echo \Yiisoft\Form\Field::input(SuffixInput::class, $procentForm, 'value')->suffix('%');
```

Result will be:

```html
<div>
    <label for="procentform-value">Value</label>
    <div class="input-group">
        <input type="text" id="procentform-value" name="ProcentForm[value]" value>
        <span class="input-group-text">%</span>
    </div>
</div>
```
