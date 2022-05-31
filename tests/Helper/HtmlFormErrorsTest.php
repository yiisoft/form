<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Helper;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Helper\HtmlFormErrors;
use Yiisoft\Form\Tests\TestSupport\Form\LoginForm;
use Yiisoft\Form\Tests\TestSupport\Form\FormWithNestedAttribute;
use Yiisoft\Form\Tests\TestSupport\TestTrait;

final class HtmlFormErrorsTest extends TestCase
{
    use TestTrait;

    private array $data = [
        'LoginForm' => [
            'login' => 'admin@.com',
            'password' => '123456',
        ],
    ];
    private array $expected = [
        'login' => ['This value is not a valid email address.'],
        'password' => ['Is too short.'],
    ];
    private LoginForm $model;

    public function testClearAllErrors(): void
    {
        $formModel = new LoginForm();
        $validator = $this->createValidatorMock();
        $this->assertTrue($formModel->load($this->data));
        $this->assertFalse($validator
            ->validate($formModel)
            ->isValid());
        $this->assertSame($this->expected, HtmlFormErrors::getAllErrors($formModel));
        $this->assertEmpty($formModel
            ->getFormErrors()
            ->clear());
    }

    public function testClearForAttribute(): void
    {
        $formModel = new LoginForm();
        $validator = $this->createValidatorMock();
        $this->assertTrue($formModel->load($this->data));
        $this->assertFalse($validator
            ->validate($formModel)
            ->isValid());
        $this->assertSame($this->expected, HtmlFormErrors::getAllErrors($formModel));
        $this->assertEmpty($formModel
            ->getFormErrors()
            ->clear('login'));
        $this->assertSame(['password' => ['Is too short.']], HtmlFormErrors::getAllErrors($formModel));
    }

    public function testGetAllErrors(): void
    {
        $formModel = new LoginForm();
        $validator = $this->createValidatorMock();
        $this->assertTrue($formModel->load($this->data));
        $this->assertFalse($validator
            ->validate($formModel)
            ->isValid());
        $this->assertSame($this->expected, HtmlFormErrors::getAllErrors($formModel));
    }

    public function testGetErrors(): void
    {
        $formModel = new LoginForm();
        $validator = $this->createValidatorMock();
        $this->assertTrue($formModel->load($this->data));
        $this->assertFalse($validator
            ->validate($formModel)
            ->isValid());
        $this->assertSame(['This value is not a valid email address.'], HtmlFormErrors::getErrors($formModel, 'login'));
    }

    public function testGetErrorSummary(): void
    {
        $formModel = new LoginForm();
        $validator = $this->createValidatorMock();
        $this->assertTrue($formModel->load($this->data));
        $this->assertFalse($validator
            ->validate($formModel)
            ->isValid());
        $this->assertSame(
            ['This value is not a valid email address.', 'Is too short.'],
            HtmlFormErrors::getErrorSummary($formModel),
        );
    }

    public function testGetErrorSummaryFirstErrors(): void
    {
        $formModel = new LoginForm();
        $validator = $this->createValidatorMock();
        $this->assertTrue($formModel->load($this->data));
        $this->assertFalse($validator
            ->validate($formModel)
            ->isValid());
        $this->assertSame(
            ['login' => 'This value is not a valid email address.', 'password' => 'Is too short.'],
            HtmlFormErrors::getErrorSummaryFirstErrors($formModel),
        );
    }

    public function testGetFirstError(): void
    {
        $formModel = new LoginForm();
        $validator = $this->createValidatorMock();
        $this->assertTrue($formModel->load($this->data));
        $this->assertFalse($validator
            ->validate($formModel)
            ->isValid());
        $this->assertSame(
            'This value is not a valid email address.',
            HtmlFormErrors::getFirstError($formModel, 'login'),
        );
    }

    public function testGetFirstErrorEmpty(): void
    {
        $this->assertSame('', HtmlFormErrors::getFirstError(new LoginForm(), 'login'));
    }

    public function testGetFirstErrorsEmpty(): void
    {
        $this->assertSame([], HtmlFormErrors::getFirstErrors(new LoginForm()));
    }

    public function testHasError(): void
    {
        $formModel = new LoginForm();
        $validator = $this->createValidatorMock();
        $this->assertTrue($formModel->load($this->data));
        $this->assertFalse($validator
            ->validate($formModel)
            ->isValid());
        $this->assertTrue(HtmlFormErrors::hasErrors($formModel));
    }

    public function testGetErrorSummaryOnlyAttributes(): void
    {
        $formModel = new LoginForm();
        $validator = $this->createValidatorMock();
        $this->assertTrue($formModel->load($this->data));
        $this->assertFalse($validator
            ->validate($formModel)
            ->isValid());
        $this->assertSame(
            ['This value is not a valid email address.'],
            HtmlFormErrors::getErrorSummary($formModel, ['login']),
        );
        $this->assertSame(
            ['Is too short.'],
            HtmlFormErrors::getErrorSummary($formModel, ['password']),
        );
    }

    public function testGetErrorNestedAttribute(): void
    {
        $formModel = new FormWithNestedAttribute();
        $validator = $this->createValidatorMock();
        $this->assertTrue($formModel->load(['FormWithNestedAttribute' => ['user.login' => 'ad']]));
        $this->assertFalse($validator
            ->validate($formModel)
            ->isValid());
        $this->assertSame(
            ['id' => 'Value cannot be blank.', 'user.login' => 'Is too short.'],
            HtmlFormErrors::getFirstErrors($formModel),
        );
        $this->assertSame(['Is too short.'], HtmlFormErrors::getErrors($formModel, 'user.login'));
        $this->assertSame(['Is too short.'], HtmlFormErrors::getErrorSummary($formModel, ['user.login']));
        $this->assertSame(
            ['id' => 'Value cannot be blank.', 'user.login' => 'Is too short.'],
            HtmlFormErrors::getErrorSummaryFirstErrors($formModel),
        );
        $this->assertSame('Is too short.', HtmlFormErrors::getFirstError($formModel, 'user.login'));
    }
}
