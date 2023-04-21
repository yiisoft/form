<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Helper;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\FormModel;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Form\Tests\TestSupport\Form\DynamicAttributesForm;
use Yiisoft\Form\Tests\TestSupport\Form\LoginForm;

final class HtmlFormTest extends TestCase
{
    public function dynamicAttributesProvider(): array
    {
        return [
            [
                [
                    [
                        'name' => '7aeceb9b-fa64-4a83-ae6a-5f602772c01b',
                        'value' => 'some uuid value',
                        'expected' => 'DynamicAttributesForm[7aeceb9b-fa64-4a83-ae6a-5f602772c01b]',
                    ],
                    [
                        'name' => 'test_field',
                        'value' => 'some test value',
                        'expected' => 'DynamicAttributesForm[test_field]',
                    ],
                ],
            ],
        ];
    }

    public function testGetAttributeHint(): void
    {
        $formModel = new LoginForm();
        $this->assertSame('Write your id or email.', HtmlForm::getAttributeHint($formModel, 'login'));

        $anonymousForm = new class () extends FormModel {
            private string $age = '';
        };
        $this->assertEmpty(HtmlForm::getAttributeHint($anonymousForm, 'age'));
    }

    public function testGetAttributeName(): void
    {
        $formModel = new LoginForm();
        $this->assertSame('login', HtmlForm::getAttributeName($formModel, '[0]login'));
        $this->assertSame('login', HtmlForm::getAttributeName($formModel, 'login[0]'));
        $this->assertSame('login', HtmlForm::getAttributeName($formModel, '[0]login[0]'));
    }

    public function testGetAttributeNameException(): void
    {
        $formModel = new LoginForm();

        $this->expectExceptionMessage("Attribute 'noExist' does not exist.");
        HtmlForm::getAttributeName($formModel, 'noExist');
    }

    public function testGetAttributeNameInvalid(): void
    {
        $formModel = new LoginForm();
        $this->expectExceptionMessage('Attribute name must contain word characters only.');
        HtmlForm::getAttributeName($formModel, 'content body');
    }

    public function dataGetInputName(): array
    {
        $loginForm = new LoginForm();
        $anonymousForm = new class () extends FormModel {
        };
        return [
            [$loginForm, '[0]content', 'LoginForm[0][content]'],
            [$loginForm, 'dates[0]', 'LoginForm[dates][0]'],
            [$loginForm, '[0]dates[0]', 'LoginForm[0][dates][0]'],
            [$loginForm, 'age', 'LoginForm[age]'],
            [$anonymousForm, 'dates[0]', 'dates[0]'],
            [$anonymousForm, 'age', 'age'],
        ];
    }

    /**
     * @dataProvider dataGetInputName
     */
    public function testGetInputName(FormModelInterface $form, string $attribute, string $expected): void
    {
        $this->assertSame($expected, HtmlForm::getInputName($form, $attribute));
    }

    public function testGetInputNameException(): void
    {
        $anonymousForm = new class () extends FormModel {
        };

        $this->expectExceptionMessage('formName() cannot be empty for tabular inputs.');
        HtmlForm::getInputName($anonymousForm, '[0]dates[0]');
    }

    public function testMultibyteGetAttributeName(): void
    {
        $formModel = new class () extends FormModel {
            private string $登录 = '';
        };
        $this->assertSame('登录', HtmlForm::getAttributeName($formModel, '[0]登录'));
        $this->assertSame('登录', HtmlForm::getAttributeName($formModel, '登录[0]'));
        $this->assertSame('登录', HtmlForm::getAttributeName($formModel, '[0]登录[0]'));
    }

    public function testMutlibyteGetInputId(): void
    {
        $formModel = new class () extends FormModel {
            private string $mĄkA = '';
        };
        $this->assertSame('mąka', HtmlForm::getInputId($formModel, 'mĄkA'));
    }

    /**
     * @dataProvider dynamicAttributesProvider
     */
    public function testUUIDInputName(array $fields): void
    {
        $keys = array_column($fields, 'name');
        $form = new DynamicAttributesForm(array_fill_keys($keys, null));

        foreach ($fields as $field) {
            $inputName = HtmlForm::getInputName($form, $field['name']);
            $this->assertSame($field['expected'], $inputName);
            $this->assertTrue($form->hasAttribute($field['name']));
            $this->assertNull($form->getAttributeValue($field['name']));
        }
    }

    public function testGetAttributePlaceholder(): void
    {
        $form = new LoginForm();

        $this->assertSame(
            'Type Password.',
            HtmlForm::getAttributePlaceHolder($form, 'password')
        );
    }
}
