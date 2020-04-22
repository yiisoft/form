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

    public function testErrors(): void
    {
        $form = new LoginForm();

        $this->assertEmpty($form->getErrors());
        $this->assertFalse($form->hasErrors('login'));

        $form->addError('login', 'No such user.');

        $this->assertTrue($form->hasErrors('login'));

        $expected = [
            'login' => [
                'No such user.'
            ]
        ];

        $this->assertEquals($expected, $form->getErrors());
        $this->assertEquals(['No such user.'], $form->getError('login'));

        $form->clearErrors();

        $this->assertEmpty($form->getErrors());

        $form->addErrors([
            'login' => [
                'No such user.',
                'String max(40).'
            ],
            'password' => [
                'Password invalid.',
                'String max(50).'
            ],
        ]);

        $this->assertEquals('No such user.', $form->getFirstError('login'));
        $this->assertEquals(['login' => 'No such user.', 'password' => 'Password invalid.'], $form->getFirstErrors());
    }

    public function testAttributes(): void
    {
        $form = new LoginForm();

        $expected = [
            'login' => 'string',
            'password' => 'string',
            'rememberMe' => 'bool',
        ];

        $this->assertEquals($expected, $form->getAttributes());
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

    public function testGetAttributes(): void
    {
        $form = new LoginForm();

        $expected = [
            'login' => 'string',
            'password' => 'string',
            'rememberMe' => 'bool',
        ];

        $this->assertEquals($expected, $form->getAttributes());
    }

    public function testGetAttributeHint(): void
    {
        $form = new LoginForm();

        $this->assertEquals('Write your id or email.', $form->getAttributeHint('login'));
        $this->assertEquals('Write your password.', $form->getAttributeHint('password'));
        $this->assertEmpty($form->getAttributeHint('noExist'));
    }

    public function testGetAttributeLabel(): void
    {
        $form = new LoginForm();

        $this->assertEquals('Login:', $form->getAttributeLabel('login'));
        $this->assertEquals('Testme', $form->getAttributeLabel('testme'));
    }

    public function testGetAttributesLabels(): void
    {
        $form = new LoginForm();

        $expected = [
            'login' => 'Login:',
            'password' => 'Password:',
            'rememberMe' => 'remember Me:'
        ];

        $this->assertEquals($expected, $form->attributeLabels());
    }

    public function testGetErrorSummary(): void
    {
        $form = new LoginForm();

        $data = [
            'LoginForm' => [
                'login' => 'admin@.com',
                'password' => '123456'
            ]
        ];

        $expected = [
            'This value is not a valid email address.',
            'Is too short.'
        ];

        $form->load($data);
        $form->validate();

        $this->assertEquals(
            $expected,
            $form->getErrorSummary(true)
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
            $form->getError('login')
        );

        $form->login('x');
        $form->validate();
        $this->assertEquals(
            ['Is too short.'],
            $form->getError('login')
        );

        $form->login(\str_repeat('x', 60));
        $form->validate();
        $this->assertEquals(
            'Is too long.',
            $form->getFirstError('login')
        );

        $form->login('admin@.com');
        $form->validate();
        $this->assertEquals(
            'This value is not a valid email address.',
            $form->getFirstError('login')
        );
    }
}
