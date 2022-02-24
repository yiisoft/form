<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Each;
use Yiisoft\Validator\Rule\HasLength;
use Yiisoft\Validator\RuleSet;

final class EachForm extends FormModel
{
    private array $names = [];

    public function getRules(): array
    {
        return ['names' => [new Each(new RuleSet([new HasLength(max: 10)]))]];
    }
}
