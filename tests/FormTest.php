<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use Yiisoft\Form\Tests\Stub\LoginForm;

final class FormTest extends TestCase
{
    public function testGetFormName(): void
    {
        $form = new LoginForm();
        $this->assertEquals('LoginForm', $form->formName());
    }

    public function testGetAttributeValue(): void
    {
        $form = new LoginForm();

        $form->login('admin');
        $this->assertEquals('admin', $form->getAttributeValue('login'));

        $form->password('123456');
        $this->assertEquals('123456', $form->getAttributeValue('password'));

        $form->rememberMe(true);
        $this->assertEquals(true, $form->getAttributeValue('rememberMe'));

        try {
            $form->getAttributeValue('noExist');
        } catch (\Exception $e) {
            $this->assertEquals(
                'Undefined property: Yiisoft\Form\Tests\Stub\LoginForm::$noExist',
                $e->getMessage()
            );
        }
    }

    public function testGetAttributeHint(): void
    {
        $form = new LoginForm();

        $this->assertEquals('Write your id or email.', $form->attributeHint('login'));
        $this->assertEquals('Write your password.', $form->attributeHint('password'));
        $this->assertEmpty($form->attributeHint('noExist'));
    }

    public function testGetAttributeLabel(): void
    {
        $form = new LoginForm();

        $this->assertEquals('Login:', $form->attributeLabel('login'));
        $this->assertEquals('Testme', $form->attributeLabel('testme'));
    }

    public function testAttributesLabels(): void
    {
        $form = new LoginForm();

        $expected = [
            'login' => 'Login:',
            'password' => 'Password:',
            'rememberMe' => 'remember Me:'
        ];

        $this->assertEquals($expected, $form->attributeLabels());
    }

    public function testErrorSummary(): void
    {
        $form = new LoginForm();

        $data = [
            'LoginForm' => [
                'login' => 'admin@.com',
                'password' => '123456'
            ]
        ];

        $expected = [
            'login' => 'This value is not a valid email address.',
            'password' => 'Is too short.'
        ];

        $form->load($data);
        $form->validate();

        $this->assertEquals(
            $expected,
            $form->errorSummary(false)
        );

        $expected = [
            'This value is not a valid email address.',
            'Is too short.'
        ];

        $this->assertEquals(
            $expected,
            $form->errorSummary(true)
        );
    }

    public function testHasAttribute(): void
    {
        $form = new LoginForm();

        $this->assertTrue($form->hasAttribute('login'));
        $this->assertFalse($form->hasAttribute('noExist'));
    }

    public function testLoad(): void
    {
        $form = new LoginForm();

        $this->assertNull($form->getLogin());
        $this->assertNull($form->getPassword());
        $this->assertFalse($form->getRememberMe());

        $data = [
            'LoginForm' => [
                'login' => 'admin',
                'password' => '123456',
                'rememberMe' => true,
                'noExist' => 'noExist'
            ]
        ];

        $form->load($data);

        $this->assertEquals('admin', $form->getLogin());
        $this->assertEquals('123456', $form->getPassword());
        $this->assertEquals(true, $form->getRememberMe());
    }

    public function testValidatorRules(): void
    {
        $form = new LoginForm();

        $form->login('');
        $form->validate();

        $this->assertEquals(
            ['Value cannot be blank.'],
            $form->error('login')
        );

        $form->login('x');
        $form->validate();
        $this->assertEquals(
            ['Is too short.'],
            $form->error('login')
        );

        $form->login(\str_repeat('x', 60));
        $form->validate();
        $this->assertEquals(
            'Is too long.',
            $form->firstError('login')
        );

        $form->login('admin@.com');
        $form->validate();
        $this->assertEquals(
            'This value is not a valid email address.',
            $form->firstError('login')
        );
    }
}
