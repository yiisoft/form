<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Email;
use Yiisoft\Validator\Rule\Required;

final class AttributeForm extends FormModel
{
    #[Required()]
    private string $attribute = '';
    private string $attributeRule = '';

    public function getRules(): array
    {
        return [
            'attribute' => [
                new Email(),
            ],
            'attributeRule' => [
                new Required(),
            ],
        ];
    }
}
