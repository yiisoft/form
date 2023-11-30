<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;
use Yiisoft\Form\YiisoftFormModel\FormModelInputData;
use Yiisoft\Form\Exception\PropertyNotSupportNestedValuesException;
use Yiisoft\Form\Exception\UndefinedObjectPropertyException;
use Yiisoft\Form\YiisoftFormModel\FormModel;
use Yiisoft\Form\Tests\Support\Form\NestedForm;
use Yiisoft\Form\Tests\Support\StubInputField;
use Yiisoft\Form\Tests\Support\TestHelper;
use Yiisoft\Form\Tests\TestSupport\Dto\Coordinates;
use Yiisoft\Form\Tests\TestSupport\Form\CustomFormNameForm;
use Yiisoft\Form\Tests\TestSupport\Form\DefaultFormNameForm;
use Yiisoft\Form\Tests\TestSupport\Form\FormWithNestedProperty;
use Yiisoft\Form\Tests\TestSupport\Form\FormWithNestedStructures;
use Yiisoft\Form\Tests\TestSupport\Form\LoginForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;

require __DIR__ . '/TestSupport/Form/NonNamespacedForm.php';

final class FormModelTest extends TestCase
{
    use TestTrait;

    public function testAnonymousFormName(): void
    {
        $form = new class () extends FormModel {
        };
        $this->assertSame('', $form->getFormName());
    }

    public function testCustomFormName(): void
    {
        $form = new CustomFormNameForm();
        $this->assertSame('my-best-form-name', $form->getFormName());
    }

    public function testDefaultFormName(): void
    {
        $form = new DefaultFormNameForm();
        $this->assertSame('DefaultFormNameForm', $form->getFormName());
    }

    public function testArrayValue(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="nestedform-letters-0">Letters</label>
        <input type="text" id="nestedform-letters-0" name="NestedForm[letters][0]" value="A">
        </div>
        HTML;

        $result = StubInputField::widget()
            ->inputData(new FormModelInputData(new NestedForm(), 'letters[0]'))
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testNonExistArrayValue(): void
    {
        $widget = StubInputField::widget()->inputData(new FormModelInputData(new NestedForm(), 'letters[1]'));

        $result = $widget->render();

        $this->assertSame(
            <<<HTML
            <div>
            <label for="nestedform-letters-1">Letters</label>
            <input type="text" id="nestedform-letters-1" name="NestedForm[letters][1]" value>
            </div>
            HTML,
            $result
        );
    }

    public function testArrayValueIntoObject(): void
    {
        $expected = <<<'HTML'
        <div>
        <label for="nestedform-object-numbers-1">Object</label>
        <input type="text" id="nestedform-object-numbers-1" name="NestedForm[object][numbers][1]" value="42">
        </div>
        HTML;

        $result = StubInputField::widget()
            ->inputData(new FormModelInputData(new NestedForm(), 'object[numbers][1]'))
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testGetAttributeHint(): void
    {
        $form = new LoginForm();

        $this->assertSame('Write your id or email.', $form->getAttributeHint('login'));
        $this->assertSame('Write your password.', $form->getAttributeHint('password'));
        $this->assertEmpty($form->getAttributeHint('noExist'));
    }

    public function testGetAttributeLabel(): void
    {
        $form = new LoginForm();

        $this->assertSame('Login:', $form->getAttributeLabel('login'));
        $this->assertSame('Testme', $form->getAttributeLabel('testme'));
    }

    public function testGetAttributesLabels(): void
    {
        $form = new LoginForm();

        $expected = [
            'login' => 'Login:',
            'password' => 'Password:',
            'rememberMe' => 'remember Me:',
        ];

        $this->assertSame($expected, $form->getAttributeLabels());
    }

    public function testNestedPropertyOnNull(): void
    {
        $form = new FormWithNestedProperty();

        $this->assertFalse($form->hasAttribute('id.profile'));
        $this->assertNull($form->getAttributeValue('id.profile'));
    }

    public function testNestedPropertyOnArray(): void
    {
        $form = new FormWithNestedProperty();

        $this->assertFalse($form->hasAttribute('meta.profile'));
        $this->assertNull($form->getAttributeValue('meta.profile'));
    }

    public function testNestedPropertyOnString(): void
    {
        $form = new FormWithNestedProperty();

        $this->assertFalse($form->hasAttribute('key.profile'));

        $this->expectException(PropertyNotSupportNestedValuesException::class);
        $this->expectExceptionMessage(
            'Property "' . FormWithNestedProperty::class . '::key" is not a nested attribute.'
        );
        $form->getAttributeValue('key.profile');
    }

    public function testNestedPropertyOnObject(): void
    {
        $form = new FormWithNestedProperty();

        $this->assertFalse($form->hasAttribute('coordinates.profile'));

        $this->expectException(UndefinedObjectPropertyException::class);
        $this->expectExceptionMessage(
            'Undefined object property: "' . FormWithNestedProperty::class . '::coordinates::profile".'
        );
        $form->getAttributeValue('coordinates.profile');
    }

    public function testGetNestedAttributeHint(): void
    {
        $form = new FormWithNestedProperty();

        $this->assertSame('Write your id or email.', $form->getAttributeHint('user.login'));
    }

    public function testGetNestedAttributeLabel(): void
    {
        $form = new FormWithNestedProperty();

        $this->assertSame('Login:', $form->getAttributeLabel('user.login'));
    }

    public function testGetNestedAttributePlaceHolder(): void
    {
        $form = new FormWithNestedProperty();

        $this->assertSame('Type Username or Email.', $form->getAttributePlaceHolder('user.login'));
    }

    public function testGetAttributePlaceHolder(): void
    {
        $form = new LoginForm();

        $this->assertSame('Type Username or Email.', $form->getAttributePlaceHolder('login'));
        $this->assertSame('Type Password.', $form->getAttributePlaceHolder('password'));
        $this->assertEmpty($form->getAttributePlaceHolder('noExist'));
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

    public function testGetAttributeValueException(): void
    {
        $form = new LoginForm();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Undefined object property: "Yiisoft\Form\Tests\TestSupport\Form\LoginForm::noExist".'
        );
        $form->getAttributeValue('noExist');
    }

    public function testGetAttributeValueWithNestedAttribute(): void
    {
        $form = new FormWithNestedProperty();

        $form->setUserLogin('admin');
        $this->assertSame('admin', $form->getAttributeValue('user.login'));
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

    public function testHasNestedAttribute(): void
    {
        $form = new FormWithNestedProperty();

        $this->assertTrue($form->hasAttribute('user.login'));
        $this->assertTrue($form->hasAttribute('user.password'));
        $this->assertTrue($form->hasAttribute('user.rememberMe'));
        $this->assertFalse($form->hasAttribute('noexist'));
    }

    public function testHasNestedAttributeException(): void
    {
        $form = new FormWithNestedProperty();

        $this->assertFalse($form->hasAttribute('user.noexist'));
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
                'noExist' => 'noExist',
            ],
        ];

        $this->assertTrue(TestHelper::createFormHydrator()->populate($form, $data));

        $this->assertSame('admin', $form->getLogin());
        $this->assertSame('123456', $form->getPassword());
        $this->assertSame(true, $form->getRememberMe());
    }

    public function testLoadFailedForm(): void
    {
        $form1 = new LoginForm();
        $form2 = new class () extends FormModel {
        };

        $data1 = [
            'LoginForm2' => [
                'login' => 'admin',
                'password' => '123456',
                'rememberMe' => true,
                'noExist' => 'noExist',
            ],
        ];
        $data2 = [];

        $hydrator = TestHelper::createFormHydrator();

        $this->assertFalse($hydrator->populate($form1, $data1));
        $this->assertFalse($hydrator->populate($form1, $data2));

        $this->assertTrue($hydrator->populate($form2, $data1));
        $this->assertTrue($hydrator->populate($form2, $data2));
    }

    public function testLoadWithEmptyScope(): void
    {
        $form = new class () extends FormModel {
            private int $int = 1;
            private string $string = 'string';
            private float $float = 3.14;
            private bool $bool = true;
        };
        TestHelper::createFormHydrator()->populate(
            $form,
            [
                'int' => '2',
                'float' => '3.15',
                'bool' => '0',
                'string' => 555,
            ],
            scope: '',
        );

        $this->assertSame(2, $form->getAttributeValue('int'));
        $this->assertSame(3.15, $form->getAttributeValue('float'));
        $this->assertSame(false, $form->getAttributeValue('bool'));
        $this->assertSame('555', $form->getAttributeValue('string'));
    }

    public function testLoadWithNestedProperty(): void
    {
        $form = new FormWithNestedProperty();

        $data = [
            'FormWithNestedProperty' => [
                'user.login' => 'admin',
            ],
        ];

        $this->assertTrue(TestHelper::createFormHydrator()->populate($form, $data));
        $this->assertSame('admin', $form->getUserLogin());
    }

    public function testLoadObjectData(): void
    {
        $form = new LoginForm();

        $result = TestHelper::createFormHydrator()->populate($form, new stdClass());

        $this->assertFalse($result);
    }

    public function testLoadNullData(): void
    {
        $form = new LoginForm();

        $result = TestHelper::createFormHydrator()->populate($form, null);

        $this->assertFalse($result);
    }

    public function testLoadNonArrayScopedData(): void
    {
        $form = new LoginForm();

        $result = TestHelper::createFormHydrator()->populate($form, ['LoginForm' => null]);

        $this->assertFalse($result);
    }

    public function testNonNamespacedFormName(): void
    {
        $form = new \NonNamespacedForm();
        $this->assertSame('NonNamespacedForm', $form->getFormName());
    }

    public function testPublicAttributes(): void
    {
        $form = new class () extends FormModel {
            public int $int = 1;
        };

        // check row data value.
        TestHelper::createFormHydrator()->populate($form, ['int' => '2']);
        $this->assertSame(2, $form->getAttributeValue('int'));
    }

    public function testFormWithNestedStructures(): void
    {
        $form = new FormWithNestedStructures();

        TestHelper::createFormHydrator()->populate($form, [
            'FormWithNestedStructures' => [
                'array' => ['a' => 'b', 'nested' => ['c' => 'd']],
                'coordinates' => ['latitude' => '12.24', 'longitude' => '56.78'],
            ],
        ]);

        $this->assertSame(['a' => 'b', 'nested' => ['c' => 'd']], $form->getAttributeValue('array'));

        $coordinates = $form->getAttributeValue('coordinates');
        $this->assertInstanceOf(Coordinates::class, $coordinates);
        $this->assertSame('12.24', $coordinates->getLatitude());
        $this->assertSame('56.78', $coordinates->getLongitude());
    }
}
