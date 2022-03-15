<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Validator;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Helper\HtmlFormErrors;
use Yiisoft\Form\Tests\TestSupport\Form\MainFormNested;
use Yiisoft\Form\Tests\TestSupport\Form\NestedForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Field;

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
                    'value' => 'main-form',
                    'nestedForm.number' => 2,
                ],
            ],
        );

        $this->assertSame('main-form', $form->getAttributeValue('value')); // main-form
        $this->assertSame(2, $form->getAttributeValue('nestedForm.number')); // 2
        $this->assertTrue($validator->validate($form)->isValid()); // should return true, returns false.
    }
}
