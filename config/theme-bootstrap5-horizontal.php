<?php

declare(strict_types=1);

use Yiisoft\Form\Field\Button;
use Yiisoft\Form\Field\ButtonGroup;
use Yiisoft\Form\Field\Checkbox;
use Yiisoft\Form\Field\CheckboxList;
use Yiisoft\Form\Field\ErrorSummary;
use Yiisoft\Form\Field\RadioList;
use Yiisoft\Form\Field\Range;
use Yiisoft\Form\Field\ResetButton;
use Yiisoft\Form\Field\Select;
use Yiisoft\Form\Field\SubmitButton;

return [
    'template' => "{label}\n<div class=\"col-sm-10\">{input}\n{hint}\n{error}</div>",
    'containerClass' => 'mb-3 row',
    'labelClass' => 'col-sm-2 col-form-label',
    'inputClass' => 'form-control',
    'hintClass' => 'form-text',
    'errorClass' => 'invalid-feedback',
    'inputValidClass' => 'is-valid',
    'inputInvalidClass' => 'is-invalid',
    'fieldConfigs' => [
        Checkbox::class => [
            'inputContainerTag()' => ['div'],
            'addInputContainerClass()' => ['form-check'],
            'inputClass()' => ['form-check-input'],
            'inputLabelClass()' => ['form-check-label'],
        ],
        CheckboxList::class => [
            'addCheckboxAttributes()' => [['class' => 'form-check-input']],
            'addCheckboxLabelAttributes()' => [['class' => 'form-check']],
            'addErrorClass()' => ['d-block'],
        ],
        RadioList::class => [
            'addRadioAttributes()' => [['class' => 'form-check-input']],
            'addRadioLabelAttributes()' => [['class' => 'form-check']],
            'addErrorClass()' => ['d-block'],
        ],
        ErrorSummary::class => [
            'containerClass()' => ['alert alert-danger'],
            'listAttributes()' => [['class' => 'mb-0']],
            'headerTag()' => ['h4'],
            'headerAttributes()' => [['class' => 'alert-heading']],
        ],
        Button::class => [
            'buttonClass()' => ['btn btn-secondary'],
        ],
        SubmitButton::class => [
            'buttonClass()' => ['btn btn-primary'],
        ],
        ResetButton::class => [
            'buttonClass()' => ['btn btn-secondary'],
        ],
        ButtonGroup::class => [
            'inputContainerTag()' => ['div'],
            'addInputContainerClass()' => ['btn-group'],
            'addButtonAttributes()' => [['class' => 'btn btn-secondary']],
        ],
        Range::class => [
            'inputClass()' => ['form-range'],
        ],
        Select::class => [
            'inputClass()' => ['form-select'],
        ],
    ],
];
