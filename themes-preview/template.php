<?php

declare(strict_types=1);

use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\Factory\Field;
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
    echo Field::text()->label('Text Field')->placeholder('Placeholder')->hint('Example of hint');

    echo Text::widget()
        ->inputData(new PureInputData(validationErrors: []))
        ->label('Valid Text Field')
        ->placeholder('Placeholder');

    echo Field::text()->label('Invalid Text Field')->placeholder('Placeholder')->error('Example of error');

    echo Field::textarea()->label('Textarea Field')->placeholder('Placeholder');

    echo Field::password()->label('Password Field')->placeholder('Placeholder');

    echo Field::url()->label('Url Field')->placeholder('Placeholder');

    echo Field::email()->label('Email Field')->placeholder('Placeholder');

    echo Field::time()->label('Time Field');

    echo Field::date()->label('Date Field');

    echo Field::dateTime()->label('DateTime Field');

    echo Field::dateTimeLocal()->label('DateTimeLocal Field');

    echo Field::telephone()->label('Telephone Field')->placeholder('Placeholder');

    echo Field::number()->label('Number Field')->placeholder('Placeholder');

    echo Field::range()->label('Range Field');

    echo Field::select()
        ->label('Select Field')
        ->optionsData(['Red', 'Green', 'Blue']);

    echo Field::checkbox()->label('Checkbox Field');

    echo Field::checkboxList('checkbox-list')
        ->label('Checkbox List Field')
        ->itemsFromValues(['One', 'Two', 'Three']);

    echo Field::radioList('radio-list')
        ->label('Radio List Field')
        ->itemsFromValues(['One', 'Two', 'Three']);

    echo Field::file()->label('File Field');

    echo Field::image('image-field.png');

    echo Field::button('Button');

    echo Field::submitButton('Submit Button');

    echo Field::resetButton('Reset Button');

    echo Field::buttonGroup()->buttonsData([['This'], ['is'], ['button'], ['group']]);

    $fieldset = Field::fieldset()->legend('Fieldset');
    echo $fieldset->begin();
    echo Field::text()->label('First Name');
    echo Field::text()->label('Last Name');
    echo $fieldset::end();

    echo Field::errorSummary(
        [
            'name' => ['Value not passed.'],
            'number' => ['Value must be no greater than 7.'],
            'colors' => ['Value must be array or iterable.'],
        ]
    )->header('Error Summary');

    echo Field::label('Label Example');

    echo Field::hint('Hint Example');

    echo Field::error('Error Example')->addAttributes(['style' => 'display: block;']);
    ?>
</div>
</body>
</html>
