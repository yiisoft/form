<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\YiisoftFormModel\Support\Form;

use Yiisoft\Form\YiisoftFormModel\FormModel;

final class CustomFormNameForm extends FormModel
{
    public function getFormName(): string
    {
        return 'my-best-form-name';
    }
}
