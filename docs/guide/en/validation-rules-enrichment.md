# Validation rules enrichment

Enrichment of the fields from validation rules is the concept / extension point allowing:

- provide extra configuration / parameters depending on validation rules in the class implementing
  `Yiisoft\Form\ValidationRulesEnricherInterface`;
- apply these parameters in the field.

1. Create validation rules enricher:

```php
use Yiisoft\Form\Field\Base\BaseField;
use Yiisoft\Form\ValidationRulesEnricherInterface;

final class MyValidationRulesEnricher implements ValidationRulesEnricherInterface 
{
    public function process(BaseField $field, mixed $rules): ?array
    {
        if ($field instanceof Text) {
            $enrichment = [];
            foreach ($rules as $rule) {                        
                if ($rule[0] === 'required') {
                    $enrichment['inputAttributes']['required'] = true;
                    $enrichment['containerAttributes']['aria-required'] = true;
                }
                
                // Handling of other rules
            }                        
        }
        
        // Handling of other fields
    
        return $enrichment;
    }
}
```

For built-in fields `inputAttributes` are supported and handled out of the box. For custom fields enrichment structure
can be arbitrary.

2. If you are using custom field, initialize enrichment in `beforeRender()` hook and handle it in the appropriate
   method(s). Enrichment is not limited to input attributes only, you can also handle container attributes, etc.

```php
use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Html\Html;

final class MyTextField extends InputField 
{    
    // ...    
    
    protected function beforeRender(): void
    {
        if ($this->enrichFromValidationRules) {
            $this->enrichment = $this
                ->validationRulesEnricher
                ?->process($this, $this->getInputData()->getValidationRules())
                ?? [];
        }
    }
    
    protected function generateInput(): string
    {
        $value = $this->getValue();
        
        // Validation of value (if it's needed)

        $inputAttributes = array_merge(
            $this->enrichment['inputAttributes'] ?? [],
            $this->getInputAttributes()
        );

        return Html::input('email', $this->getName(), $value, $inputAttributes)->render();
    }
    
    protected function prepareContainerAttributes(array &$attributes): void 
    { 
        $attributes = array_merge($attributes, $this->enrichment['containerAttributes'] ?? []); 
        
        return parent::prepareContainerAttrbiutes($attributes);
    }
    
    // ...
}
```

Another case is to add thematic icons: for example - letter icon for `Email` field and so on.

3. Register your custom validation rules enricher. It's done globally via theme container:

```php
\Yiisoft\Form\Theme\ThemeContainer::initialize(validationRulesEnricher: new MyValidationRulesEnricher());
```

4. Now, when creating field, provide validation rules within input data and enrichment

```php
use Yiisoft\Form\Field\Text;
use Yiisoft\Form\PureField\InputData;

echo Text::widget()
    ->inputData(new InputData(validationRules: [['required']]) 
```

The field will be enriched automatically:

```html
<div aria-required="true">
    <input type="text" required>
</div>
```

## Enable / disable enrichment

When using custom field, implement `EnrichFromValidationRulesInterface` to control whether enrichment should be
activated. There is a trait - `Yiisoft\Form\Field\Base\EnrichFromValidationRules\EnrichFromValidationRulesTrait` with
ready-to-use implementation.

```php
use Yiisoft\Form\Field\Base\EnrichFromValidationRules\EnrichFromValidationRulesInterface;
use Yiisoft\Form\Field\Base\EnrichFromValidationRules\EnrichFromValidationRulesTrait;
use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Html\Html;

final class MyTextField extends InputField implements EnrichFromValidationRulesInterface
{
    use EnrichFromValidationRulesTrait;             
}
```

Some built-in fields also support [this feature](field-methods.md#enrichfromvalidationrulesinterface-implemented-fields).

You can disable enrichment:

```php
echo Yiisoft\Form\Field\Text::widget()->enrichFromValidationRules(false);
```

or enable it (default):

```php
echo Yiisoft\Form\Field\Text::widget()->enrichFromValidationRules();
```

## Implementations

[Form Model](https://github.com/yiisoft/form-model) package has its
[own implementation](https://github.com/yiisoft/form-model/blob/master/src/ValidationRulesEnricher.php) of validation
rules enricher. It's based on [Validator](https://github.com/yiisoft/validator) rules and helps to automatically fill
HTML attributes of the input based on the rules configuration - for example, `min` and `max` attributes for `Number`
field.
