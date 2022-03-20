<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;

final class FormWithDeepNested extends FormModel
{
    protected int $intValue = 1;
    protected PersonalForm $personalForm;
    protected FormWithNestedAttribute $nestedForm;

    public function __construct()
    {
        parent::__construct();

        $this->personalForm = new PersonalForm();
        $this->nestedForm = new FormWithNestedAttribute();
    }
}
