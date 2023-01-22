<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\AttributeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;

final class ValidatorAttributeTest extends TestCase
{
    use TestTrait;

    public function testValidatorAttribute(): void
    {
        $validator = $this->createValidatorMock();
        $formModel = new AttributeForm();
        $formModel->setAttribute('name', 'null');
        $formModel->setAttribute('email', 't');
        $validator->validate($formModel)->isValid();
        $this->assertSame(
            ['username' => 'Value cannot be blank.', 'email' => 'This value is not a valid email address.'],
            $formModel->getFormErrors()->getFirstErrors(),
        );
    }
}
