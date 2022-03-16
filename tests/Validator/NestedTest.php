<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Validator;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Helper\HtmlFormErrors;
use Yiisoft\Form\Tests\TestSupport\Form\MainFormNested;
use Yiisoft\Form\Tests\TestSupport\TestTrait;

final class NestedTest extends TestCase
{
    use TestTrait;

    public function testAttributeNestedValidation(): void
    {
        $form = new MainFormNested();

        $validator = $this->createValidatorMock();
        $form->load(
            [
                'MainFormNested' => [
                    'nestedForm.id' => '1',
                    'nestedForm.number' => 2,
                    'value' => 'main-form',
                ],
            ],
        );

        $this->assertSame('1', $form->getAttributeValue('nestedForm.id')); // '1' is valid.
        $this->assertSame(2, $form->getAttributeValue('nestedForm.number')); // 2 is valid.
        $this->assertSame('main-form', $form->getAttributeValue('value')); // main-form is valid.
        $this->assertTrue($validator->validate($form)->isValid()); // return true
        $this->assertEmpty(HtmlFormErrors::getAllErrors($form));
    }

    public function testAttributeNestedValidationInvalidId(): void
    {
        $form = new MainFormNested();

        $validator = $this->createValidatorMock();
        $form->load(
            [
                'MainFormNested' => [
                    'nestedForm.id' => '',
                    'nestedForm.number' => 2,
                    'value' => 'main-form',
                ],
            ],
        );

        $this->assertSame('', $form->getAttributeValue('nestedForm.id')); // empty string is invalid.
        $this->assertSame(2, $form->getAttributeValue('nestedForm.number')); // 2 is valid.
        $this->assertSame('main-form', $form->getAttributeValue('value')); // main-form is valid.
        $this->assertFalse($validator->validate($form)->isValid()); // return false.
        $this->assertSame(['nestedForm.number' => ['Value cannot be blank.']], HtmlFormErrors::getAllErrors($form));
    }

    public function testAttributeNestedValidationInvalidNumber(): void
    {
        $form = new MainFormNested();

        $validator = $this->createValidatorMock();
        $form->load(
            [
                'MainFormNested' => [
                    'nestedForm.id' => '1',
                    'nestedForm.number' => 'x',
                    'value' => 'main-form',
                ],
            ],
        );

        $this->assertSame('1', $form->getAttributeValue('nestedForm.id')); // '1' is valid.
        $this->assertSame('x', $form->getAttributeValue('nestedForm.number')); // 'x' is invalid.
        $this->assertSame('main-form', $form->getAttributeValue('value')); // main-form is valid.
        $this->assertFalse($validator->validate($form)->isValid()); // return false.
        $this->assertSame(['nestedForm.number' => ['Value must be an integer.']], HtmlFormErrors::getAllErrors($form));
    }
}
