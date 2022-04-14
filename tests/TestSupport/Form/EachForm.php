<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Each\Each;
use Yiisoft\Validator\Rule\HasLength\HasLength;

final class EachForm extends FormModel
{
    private array $names = [];

    public function getRules(): array
    {
        return ['names' => [new Each([new HasLength(max: 10)])]];
    }
}
