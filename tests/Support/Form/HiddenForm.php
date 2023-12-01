<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use Yiisoft\Form\YiisoftFormModel\FormModel;

final class HiddenForm extends FormModel
{
    private ?string $key = 'x100';
    private bool $flag = false;
}
