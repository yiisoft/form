<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Helper;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Helper\HtmlFormErrors;
use Yiisoft\Form\Tests\TestSupport\Form\LoginForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;

final class HtmlFormErrorsTest extends TestCase
{
    use TestTrait;

    public function testGetAllErrors(): void
    {
        $form = new LoginForm();

        $data = [
            'LoginForm' => [
                'login' => 'admin@.com',
                'password' => '123456',
            ],
        ];

        $expected = [
            'login' => ['This value is not a valid email address.'],
            'password' => ['Is too short.'],
        ];

        $validator = $this->createValidatorMock();

        $this->assertTrue($form->load($data));
        $this->assertFalse($validator->validate($form)->isValid());

        // check if all errors are returned
        $this->assertTrue(HtmlFormErrors::hasErrors($form));

        // get all errors
        $this->assertSame(
            $expected,
            HtmlFormErrors::getAllErrors($form),
        );

        // get errors for specific attribute
        $this->assertSame(
            ['This value is not a valid email address.'],
            HtmlFormErrors::getErrors($form, 'login'),
        );

        // get error summary first errors for specific attribute
        $this->assertSame(
            'This value is not a valid email address.',
            HtmlFormErrors::getFirstError($form, 'login'),
        );

        // get error sumamary all errors
        $this->assertSame(
            ['This value is not a valid email address.', 'Is too short.'],
            HtmlFormErrors::getErrorSummary($form),
        );

        // get first error
        $this->assertSame(
            'This value is not a valid email address.',
            HtmlFormErrors::getFirstError($form, 'login'),
        );
    }
}
