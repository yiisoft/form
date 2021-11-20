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

    public function testGetAllErrors(): void
    {
        $validator = $this->createValidatorMock();
        $this->assertTrue($this->formModel->load($this->data));
        $this->assertFalse($validator->validate($this->formModel)->isValid());
        $this->assertSame($this->expected, HtmlFormErrors::getAllErrors($this->formModel));
    }

    public function testGetErrors(): void
    {
        $validator = $this->createValidatorMock();
        $this->assertTrue($this->formModel->load($this->data));
        $this->assertFalse($validator->validate($this->formModel)->isValid());
        $this->assertSame(['This value is not a valid email address.'], HtmlFormErrors::getErrors($this->formModel, 'login'));
    }

    public function testGetErrorSummary(): void
    {
        $validator = $this->createValidatorMock();
        $this->assertTrue($this->formModel->load($this->data));
        $this->assertFalse($validator->validate($this->formModel)->isValid());
        $this->assertSame(
            ['This value is not a valid email address.', 'Is too short.'],
            HtmlFormErrors::getErrorSummary($this->formModel),
        );
    }

    public function testGetErrorSummaryFirstErrors(): void
    {
        $validator = $this->createValidatorMock();
        $this->assertTrue($this->formModel->load($this->data));
        $this->assertFalse($validator->validate($this->formModel)->isValid());
        $this->assertSame(
            ['login' => 'This value is not a valid email address.', 'password' => 'Is too short.'],
            HtmlFormErrors::getErrorSummaryFirstErrors($this->formModel),
        );
    }

    public function testGetFirstError(): void
    {
        $validator = $this->createValidatorMock();
        $this->assertTrue($this->formModel->load($this->data));
        $this->assertFalse($validator->validate($this->formModel)->isValid());
        $this->assertSame('This value is not a valid email address.', HtmlFormErrors::getFirstError($this->formModel, 'login'));
    }

    public function testGetFirstErrorEmpty(): void
    {
        $this->assertSame('', HtmlFormErrors::getFirstError($this->formModel, 'login'));
    }

    public function testGetFirstErrorsEmpty(): void
    {
        $this->assertSame([], HtmlFormErrors::getFirstErrors($this->formModel));
    }

    public function testHasError(): void
    {
        $validator = $this->createValidatorMock();
        $this->assertTrue($this->formModel->load($this->data));
        $this->assertFalse($validator->validate($this->formModel)->isValid());
        $this->assertTrue(HtmlFormErrors::hasErrors($this->formModel));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->createFormModel(LoginForm::class);
    }
}
