<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\AttributeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;

final class AttributeValidatorTest extends TestCase
{
    use TestTrait;

    public function testsValidatorAttribute(): void
    {
        $validator = $this->createValidatorMock();
        $formModel = new AttributeForm();
        $validator->validate($formModel)->isValid();
        $this->assertSame(
            [
                'attribute' => 'Value cannot be blank.',
                'attribute' => 'This value is not a valid email address.',
                'attributeRule' => 'Value cannot be blank.',
            ],
            $formModel->getFormErrors()->getFirstErrors(),
        );
    }
}
