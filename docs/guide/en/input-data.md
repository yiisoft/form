# Input data

Input data is an abstraction for storing input's value and some common meta information along with its validation rules 
/ state:

- Name - unique name of an input within the form (not visible to the end user)
- Value - filled value that is about to be sent to the server
- Label - the label associated with this form (visible to the end user)
- Hint - complimentary text explaining certain details regarding this input
- Placeholder - the value used as an example to help user fill the actual value
- ID - unique identifier in DOM (HTML)
- Validation state (whether the input has been already validated)
- Validation rules - validation rules in any format. They are intended to be processed by 
  `\Yiisoft\Form\ValidationRulesEnricherInterface::process()`
- Validation errors - the list of validation errors for this attribute

Input data classes must implement `\Yiisoft\Form\Field\Base\InputDataInterface` interface. This package already provides
ready to use implementation - `\Yiisoft\Form\PureField\InputData`. 

Once created, it can be added to existing field. From [built-in fields](built-in-fields.md) the fields that are intended
to be used for user's input or at least pass data (for example, hidden inputs) have support for adding input data. The 
exceptions are buttons, images, etc.

## Usage with fields

To add input data to a field:

```php
use Yiisoft\Form\PureField\InputData;
use Yiisoft\Form\Field\Text;

$inputData = new InputData(
    name: 'TextForm[name]',
    value: '',
    label: 'Name',
    hint: 'Input your full name.',
    placeholder: 'Type your name here',
    id: 'textform-name',
    validationRules: [['required']],
    validationErrors: ['Value cannot be blank.'],
);
$result = Text::widget()->inputData($inputData)->render();
```

The other way is to use `\Yiisoft\Form\PureField\Field` or `\Yiisoft\Form\PureField\FieldFactory`, please refer to 
[Pure fields](pure-fields.md) for details.
