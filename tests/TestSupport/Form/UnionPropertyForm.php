<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;

class UnionPropertyForm extends FormModel
{
    private array|int $prefer_array;
    private int|array $prefer_int;
}
