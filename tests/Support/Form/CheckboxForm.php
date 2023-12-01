<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Support\Form;

use stdClass;
use Yiisoft\Form\YiisoftFormModel\FormModel;

final class CheckboxForm extends FormModel
{
    private bool $red = true;
    private bool $blue = false;
    private int $age = 42;
    private stdClass $object;

    public function __construct()
    {
        $this->object = new stdClass();
    }

    public function getPropertyLabels(): array
    {
        return [
            'red' => 'Red color',
            'blue' => 'Blue color',
            'age' => 'Your age 42?',
        ];
    }

    public function getPropertyHints(): array
    {
        return [
            'red' => 'If need red color.',
        ];
    }
}
