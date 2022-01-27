<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;

final class ExampleForm extends FormModel
{
    private string $description = '';
    private string $end = '';
    private string $name = '';
    private string $start = '';
    private string $state = '';
}
