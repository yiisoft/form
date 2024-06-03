# Input data

Input data is an abstraction for storing input's value and some common meta information along with its validation rules 
/ state:

- Name - unique name of an input within the form (not visible to the end user)
- Value - filled value that is about to be sent to the server
- Label - the label associated with this form (visible to the end user)
- Hint - complimentary text explaining certain details regarding this input
- Placeholder - the prefilled value, used as a default or an example
- ID - unique identifier in DOM (HTML)
- Validation state (whether the input has been already validated)
- Validation rules - validation rules in the format supported by [validator](https://github.com/yiisoft/validator)
- Validation errors - the list of validation errors for this attribute

Input data classes must implement `Yiisoft\Form\Field\Base\InputDataInterface` interface. This package already provides
ready to use implementation - `\Yiisoft\Form\Field\Base\InputData\PureInputData`. 

Once created, it can be added to existing field. From [built-in fields](built-in-fields.md) the fields that are intended
to be used for user's input or at least pass data (for example, hidden inputs) have support for adding input data. The 
exceptions are buttons, images, etc.

## Usage with fields

To add input data to a field: 

```php
use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\Text;

$inputData = new PureInputData(
    name: 'TextForm[name]',
    value: '',
    label: 'Name',
    hint: 'Input your full name.',
    placeholder: 'Type your name here',
    id: 'textform-name',
    validationErrors: ['Value cannot be blank.'],
);
$result = Text::widget()->inputData($inputData)->render();
```

The other way is to use `\Yiisoft\Form\Field\Factory\PureField` or `\Yiisoft\Form\Field\Factory\PureFieldFactory`,
please refer to [Pure fields](pure-fields.md) for details.
