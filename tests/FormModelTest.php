<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\FormModel;
use Yiisoft\Form\Tests\TestSupport\Form\FormWithNestedAttribute;
use Yiisoft\Form\Tests\TestSupport\Form\LoginForm;
use Yiisoft\Form\Tests\TestSupport\Validator\ValidatorMock;
use Yiisoft\Validator\ValidatorInterface;

use function str_repeat;

require __DIR__ . '/TestSupport/Form/NonNamespacedForm.php';

final class FormModelTest extends TestCase
{
    public function testAnonymousFormName(): void
    {
        $form = new class () extends FormModel {};
        $this->assertSame('', $form->getFormName());
    }

    public function testDefaultFormName(): void
    {
        $form = new DefaultFormNameForm();
        $this->assertSame('DefaultFormNameForm', $form->getFormName());
    }

    public function testNonNamespacedFormName(): void
    {
        $form = new \NonNamespacedForm();
        $this->assertSame('NonNamespacedForm', $form->getFormName());
    }

    public function testCustomFormName(): void
    {
        $form = new CustomFormNameForm();
        $this->assertSame('my-best-form-name', $form->getFormName());
    }

    public function testUnknownPropertyType(): void
    {
        $form = new class () extends FormModel {
            private $property;
        };

        $form->setAttribute('property', true);
        $this->assertSame(true, $form->getAttributeValue('property'));

        $form->setAttribute('property', 'string');
        $this->assertSame('string', $form->getAttributeValue('property'));

        $form->setAttribute('property', 0);
        $this->assertSame(0, $form->getAttributeValue('property'));

        $form->setAttribute('property', 1.2563);
        $this->assertSame(1.2563, $form->getAttributeValue('property'));

        $form->setAttribute('property', []);
        $this->assertSame([], $form->getAttributeValue('property'));
    }

    public function testGetAttributeValue(): void
    {
        $form = new LoginForm();

        $form->login('admin');
        $this->assertSame('admin', $form->getAttributeValue('login'));

        $form->password('123456');
        $this->assertSame('123456', $form->getAttributeValue('password'));

        $form->rememberMe(true);
        $this->assertSame(true, $form->getAttributeValue('rememberMe'));
    }

    public function testGetAttributeValueWithNestedAttribute(): void
    {
        $form = new FormWithNestedAttribute();

        $form->setUserLogin('admin');
        $this->assertSame('admin', $form->getAttributeValue('user.login'));
    }

    public function testGetAttributeHint(): void
    {
        $form = new LoginForm();

        $this->assertSame('Write your id or email.', $form->getAttributeHint('login'));
        $this->assertSame('Write your password.', $form->getAttributeHint('password'));
        $this->assertEmpty($form->getAttributeHint('noExist'));
    }

    public function testGetNestedAttributeHint(): void
    {
        $form = new FormWithNestedAttribute();

        $this->assertSame('Write your id or email.', $form->getAttributeHint('user.login'));
    }

    public function testGetAttributeLabel(): void
    {
        $form = new LoginForm();

        $this->assertSame('Login:', $form->getAttributeLabel('login'));
        $this->assertSame('Testme', $form->getAttributeLabel('testme'));
    }

    public function testGetNestedAttributeLabel(): void
    {
        $form = new FormWithNestedAttribute();

        $this->assertSame('Login:', $form->getAttributeLabel('user.login'));
    }

    public function testAttributesLabels(): void
    {
        $form = new LoginForm();

        $expected = [
            'login' => 'Login:',
            'password' => 'Password:',
            'rememberMe' => 'remember Me:',
        ];

        $this->assertSame($expected, $form->getAttributeLabels());
    }

    public function testGetAttributePlaceHolder(): void
    {
        $form = new LoginForm();

        $this->assertSame('Type Usernamer or Email.', $form->getAttributePlaceHolder('login'));
        $this->assertSame('Type Password.', $form->getAttributePlaceHolder('password'));
        $this->assertEmpty($form->getAttributePlaceHolder('noExist'));
    }

    public function testGetNestedAttributePlaceHolder(): void
    {
        $form = new FormWithNestedAttribute();

        $this->assertSame('Type Usernamer or Email.', $form->getAttributePlaceHolder('user.login'));
    }

    public function testErrorSummary(): void
    {
        $form = new LoginForm();

        $data = [
            'LoginForm' => [
                'login' => 'admin@.com',
                'password' => '123456',
            ],
        ];

        $expected = [
            'login' => 'This value is not a valid email address.',
            'password' => 'Is too short.',
        ];

        $validator = $this->createValidatorMock();

        $this->assertTrue($form->load($data));
        $this->assertFalse($validator->validate($form)->isValid());

        $this->assertSame(
            $expected,
            $form->getErrorSummary(false)
        );

        $expected = [
            'This value is not a valid email address.',
            'Is too short.',
        ];

        $this->assertSame(
            $expected,
            $form->getErrorSummary(true)
        );
    }

    public function testHasAttribute(): void
    {
        $form = new LoginForm();

        $this->assertTrue($form->hasAttribute('login'));
        $this->assertTrue($form->hasAttribute('password'));
        $this->assertTrue($form->hasAttribute('rememberMe'));
        $this->assertFalse($form->hasAttribute('noExist'));
        $this->assertFalse($form->hasAttribute('extraField'));
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
                'rememberMe' => '1',
                'noExist' => 'noExist',
            ],
        ];

        $this->assertTrue($form->load($data));

        $this->assertSame('admin', $form->getLogin());
        $this->assertSame('123456', $form->getPassword());
        $this->assertSame(true, $form->getRememberMe());

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Undefined property: "Yiisoft\Form\Tests\TestSupport\Form\LoginForm::noExist".');
        $this->assertNull($form->getAttributeValue('noExist'));
    }

    public function testLoadRawData(): void
    {
        $form = new LoginForm();

        $this->assertNull($form->getRawAttributeValue('login'));
        $this->assertNull($form->getRawAttributeValue('password'));
        $this->assertNull($form->getRawAttributeValue('password'));

        $data = [
            'LoginForm' => [
                'login' => 'admin',
                'password' => '123456',
                'rememberMe' => '1',
            ],
        ];

        $this->assertTrue($form->load($data));

        $this->assertSame('admin', $form->getRawAttributeValue('login'));
        $this->assertSame('123456', $form->getRawAttributeValue('password'));
        $this->assertSame('1', $form->getRawAttributeValue('rememberMe'));
    }

    public function testLoadWithNestedAttribute(): void
    {
        $form = new FormWithNestedAttribute();

        $data = [
            'FormWithNestedAttribute' => [
                'user.login' => 'admin',
            ],
        ];

        $this->assertTrue($form->load($data));
        $this->assertSame('admin', $form->getUserLogin());
    }

    public function testFailedLoadForm(): void
    {
        $form1 = new LoginForm();
        $form2 = new class () extends FormModel {
        };

        $data1 = [
            'LoginForm2' => [
                'login' => 'admin',
                'password' => '123456',
                'rememberMe' => '1',
                'noExist' => 'noExist',
            ],
        ];
        $data2 = [];

        $this->assertFalse($form1->load($data1));
        $this->assertFalse($form1->load($data2));

        $this->assertTrue($form2->load($data1));
        $this->assertFalse($form2->load($data2));
    }

    public function testLoadWithEmptyScope(): void
    {
        $form = new class () extends FormModel {
            private int $int = 1;
            private string $string = 'string';
            private float $float = 3.14;
            private bool $bool = true;
        };
        $form->load([
            'int' => '2',
            'float' => '3.15',
            'bool' => 'false',
            'string' => 555,
        ], '');
        $this->assertIsInt($form->getAttributeValue('int'));
        $this->assertIsFloat($form->getAttributeValue('float'));
        $this->assertIsBool($form->getAttributeValue('bool'));
        $this->assertIsString($form->getAttributeValue('string'));
    }

    public function testAddError(): void
    {
        $form = new LoginForm();
        $errorMessage = 'Invalid password.';

        $form->addError('password', $errorMessage);

        $this->assertTrue($form->hasErrors());
        $this->assertSame($errorMessage, $form->getFirstError('password'));
    }

    public function testAddAndGetErrorForNonExistingAttribute(): void
    {
        $form = new LoginForm();
        $errorMessage = 'Invalid username and/or password.';

        $form->addError('form', $errorMessage);

        $this->assertTrue($form->hasErrors());
        $this->assertSame($errorMessage, $form->getFirstError('form'));
    }

    public function testValidatorRules(): void
    {
        $validator = $this->createValidatorMock();
        $form = new LoginForm();

        $form->login('');
        $validator->validate($form);

        $this->assertSame(
            ['Value cannot be blank.'],
            $form->getError('login')
        );

        $form->login('x');
        $validator->validate($form);
        $this->assertSame(
            ['Is too short.'],
            $form->getError('login')
        );

        $form->login(str_repeat('x', 60));
        $validator->validate($form);
        $this->assertSame(
            'Is too long.',
            $form->getFirstError('login')
        );

        $form->login('admin@.com');
        $validator->validate($form);
        $this->assertSame(
            'This value is not a valid email address.',
            $form->getFirstError('login')
        );
    }

    public function testPublicAttributes(): void
    {
        $form = new class () extends FormModel {
            public int $int = 1;
        };
        $form->load(['int' => '2']);
        $this->assertSame(2, $form->getAttributeValue('int'));

        $form->setAttribute('int', 1);
        $this->assertSame(1, $form->getAttributeValue('int'));
    }

    private function createValidatorMock(): ValidatorInterface
    {
        return new ValidatorMock();
    }
}

final class DefaultFormNameForm extends FormModel
{
}

final class CustomFormNameForm extends FormModel
{
    public function getFormName(): string
    {
        return 'my-best-form-name';
    }
}
