<?php

declare(strict_types=1);

use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\Factory\PureField;
use Yiisoft\Form\Field\Text;
use Yiisoft\Form\Theme\ThemeContainer;
use Yiisoft\Html\Html;

/**
 * @var array $params
 */

ThemeContainer::initialize(
    [
        'theme' => require $params['file'],
    ],
    'theme',
);

echo '<!DOCTYPE html>';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yii Form — <?= Html::encode($params['name']) ?></title>
    <?= $params['head'] ?>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<div style="max-width: 1000px;padding: 24px;margin: 0 auto">
    <?php
    echo PureField::text()->label('Text Field')->placeholder('Placeholder')->hint('Example of hint');

    echo Text::widget()
        ->inputData(new PureInputData(validationErrors: []))
        ->label('Valid Text Field')
        ->placeholder('Placeholder');

    echo PureField::text()->label('Invalid Text Field')->placeholder('Placeholder')->error('Example of error');

    echo PureField::textarea()->label('Textarea Field')->placeholder('Placeholder');

    echo PureField::password()->label('Password Field')->placeholder('Placeholder');

    echo PureField::url()->label('Url Field')->placeholder('Placeholder');

    echo PureField::email()->label('Email Field')->placeholder('Placeholder');

    echo PureField::time()->label('Time Field');

    echo PureField::date()->label('Date Field');

    echo PureField::dateTime()->label('DateTime Field');

    echo PureField::dateTimeLocal()->label('DateTimeLocal Field');

    echo PureField::telephone()->label('Telephone Field')->placeholder('Placeholder');

    echo PureField::number()->label('Number Field')->placeholder('Placeholder');

    echo PureField::range()->label('Range Field');

    echo PureField::select()
        ->label('Select Field')
        ->optionsData(['Red', 'Green', 'Blue']);

    echo PureField::checkbox()->label('Checkbox Field');

    echo PureField::checkboxList('checkbox-list')
        ->label('Checkbox List Field')
        ->itemsFromValues(['One', 'Two', 'Three']);

    echo PureField::radioList('radio-list')
        ->label('Radio List Field')
        ->itemsFromValues(['One', 'Two', 'Three']);

    echo PureField::file()->label('File Field');

    echo PureField::image('image-field.png');

    echo PureField::button('Button');

    echo PureField::submitButton('Submit Button');

    echo PureField::resetButton('Reset Button');

    echo PureField::buttonGroup()->buttonsData([['This'], ['is'], ['button'], ['group']]);

    $fieldset = PureField::fieldset()->legend('Fieldset');
    echo $fieldset->begin();
    echo PureField::text()->label('First Name');
    echo PureField::text()->label('Last Name');
    echo $fieldset::end();

    echo PureField::errorSummary(
        [
            'name' => ['Value not passed.'],
            'number' => ['Value must be no greater than 7.'],
            'colors' => ['Value must be array or iterable.'],
        ]
    )->header('Error Summary');

    echo PureField::label('Label Example');

    echo PureField::hint('Hint Example');

    echo PureField::error('Error Example')->addAttributes(['style' => 'display: block;']);
    ?>
</div>
</body>
</html>
