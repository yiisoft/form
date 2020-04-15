<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

final class FormTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testGetFornname(): void
    {
        $this->assertEquals('LoginForm', $this->loginForm->formName());
    }

    public function testErrors(): void
    {
        $this->assertEmpty($this->loginForm->getErrors());
        $this->assertFalse($this->loginForm->hasErrors('login'));

        $this->loginForm->addError('login', 'No such user.');

        $this->assertTrue($this->loginForm->hasErrors('login'));

        $expected = [
            'login' => [
                'No such user.'
            ]
        ];

        $this->assertEquals($expected, $this->loginForm->getErrors());
        $this->assertEquals(['No such user.'], $this->loginForm->getError('login'));

        $this->loginForm->clearErrors();

        $this->assertEmpty($this->loginForm->getErrors());

        $this->loginForm->AddErrors([
            'login' => [
                'No such user.',
                'String max(40).'
            ],
            'password' => [
                'Password invalid.',
                'String max(50).'
            ],
        ]);

        $this->assertEquals('No such user.', $this->loginForm->getFirstError('login'));
        $this->assertEquals(['login' => 'No such user.', 'password' => 'Password invalid.'], $this->loginForm->getFirstErrors());
    }

    public function testAttributes(): void
    {
        $expected = [
            'login' => 'string',
            'password' => 'string',
            'rememberMe' => 'bool',
        ];

        $this->assertEquals($expected, $this->loginForm->getAttributes());
    }

    public function testGetAttributeValue(): void
    {
        $this->loginForm->login('admin');
        $this->assertEquals('admin', $this->loginForm->getAttributeValue('login'));

        $this->loginForm->password('123456');
        $this->assertEquals('123456', $this->loginForm->getAttributeValue('password'));

        $this->loginForm->rememberMe(true);
        $this->assertEquals(true, $this->loginForm->getAttributeValue('rememberMe'));

        try {
            $this->loginForm->getAttributeValue('noExist');
        } catch (\Exception $e) {
            $this->assertEquals(
                'Undefined property: Yiisoft\Form\Tests\Stubs\LoginForm::$noExist',
                $e->getMessage()
            );
        }
    }

    public function testGetAttributes(): void
    {
        $expected = [
            'login' => 'string',
            'password' => 'string',
            'rememberMe' => 'bool',
        ];

        $this->assertEquals($expected, $this->loginForm->getAttributes());
    }

    public function testGetAttributeHint(): void
    {
        $this->assertEquals('Write your id or email.', $this->loginForm->getAttributeHint('login'));
        $this->assertEquals('Write your password.', $this->loginForm->getAttributeHint('password'));
        $this->assertEmpty($this->loginForm->getAttributeHint('noExist'));
    }

    public function testGetAttributeLabel(): void
    {
        $this->assertEquals('Login:', $this->loginForm->getAttributeLabel('login'));
        $this->assertEquals('Testme', $this->loginForm->getAttributeLabel('testme'));
    }

    public function testGetAttributesLabels(): void
    {
        $expected = [
            'login' => 'Login:',
            'password' => 'Password:',
            'rememberMe' => 'remember Me:'
        ];

        $this->assertEquals($expected, $this->loginForm->attributeLabels());
    }

    public function testHasAttribute()
    {
        $this->assertTrue($this->loginForm->hasAttribute('login'));
        $this->assertFalse($this->loginForm->hasAttribute('noExist'));
    }

    public function testLoad(): void
    {
        $this->assertNull($this->loginForm->getLogin());
        $this->assertNull($this->loginForm->getPassword());
        $this->assertFalse($this->loginForm->getRememberMe());

        $data = [
            'LoginForm' => [
                'login' => 'admin',
                'password' => '123456',
                'rememberMe' => true,
                'noExist' => 'noExist'
            ]
        ];

        $this->loginForm->load($data);

        $this->assertEquals('admin', $this->loginForm->getLogin());
        $this->assertEquals('123456', $this->loginForm->getPassword());
        $this->assertEquals(true, $this->loginForm->getRememberMe());
    }

    public function testValidatorRules(): void
    {
        $this->loginForm->login('');
        $this->loginForm->validate();
        $this->assertEquals(
            ['Value cannot be blank.'],
            $this->loginForm->getError('login')
        );

        $this->loginForm->login('x');
        $this->loginForm->validate();
        $this->assertEquals(
            ['Is too short.'],
            $this->loginForm->getError('login')
        );

        $this->loginForm->login(\str_repeat('x', 60));
        $this->loginForm->validate();
        $this->assertEquals(
            'Is too long.',
            $this->loginForm->getFirstError('login')
        );

        $this->loginForm->login('admin@.com');
        $this->loginForm->validate();
        $this->assertEquals(
            'This value is not a valid email address.',
            $this->loginForm->getFirstError('login')
        );
    }
}
