<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Form\LoadMultipleTrait;

final class LoadMultipleForm extends FormModel
{
    use LoadMultipleTrait;

    private string $attribute1 = '';
    private string $attribute2 = '';
    private string $attribute3 = '';
    private string $attribute4 = '';
}
