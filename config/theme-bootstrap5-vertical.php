<?php

declare(strict_types=1);

use Yiisoft\Form\Field\Checkbox;
use Yiisoft\Form\Field\CheckboxList;
use Yiisoft\Form\Field\ErrorSummary;
use Yiisoft\Form\Field\RadioList;
use Yiisoft\Form\Field\SubmitButton;

return [
    'template' => "{label}\n{input}\n{hint}\n{error}",
    'containerClass' => 'mb-3',
    'labelClass' => 'form-label',
    'inputClass' => 'form-control',
    'hintClass' => 'form-text',
    'errorClass' => 'invalid-feedback',
    'inputValidClass' => 'is-valid',
    'inputInvalidClass' => 'is-invalid',
    'fieldConfigs' => [
        Checkbox::class => [
            'addContainerClass()' => ['form-check'],
            'inputClass()' => ['form-check-input'],
            'inputLabelClass()' => ['form-check-label'],
        ],
        CheckboxList::class => [
            'addCheckboxAttributes()' => [['class' => 'form-check-input']],
            'addCheckboxLabelAttributes()' => [['class' => 'form-check']],
        ],
        RadioList::class => [
            'addRadioAttributes()' => [['class' => 'form-check-input']],
            'addRadioLabelAttributes()' => [['class' => 'form-check']],
        ],
        ErrorSummary::class => [
            'containerClass()' => ['alert alert-danger'],
            'listAttributes()' => [['class' => 'mb-0']],
            'header()' => [''],
        ],
        SubmitButton::class => [
            'buttonClass()' => ['btn btn-primary'],
        ],
    ],
];
