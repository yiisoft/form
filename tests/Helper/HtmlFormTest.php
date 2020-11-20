<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Helper;

use Yiisoft\Form\FormModel;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Form\Tests\Stub\LoginForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\ValidatorFactoryMock;

final class HtmlFormTest extends TestCase
{
    public function testGetAttributeName(): void
    {
        $this->assertSame('content', HtmlForm::getAttributeName('[0]content'));
        $this->assertSame('dates', HtmlForm::getAttributeName('dates[0]'));
        $this->assertSame('dates', HtmlForm::getAttributeName('[0]dates[0]'));

        $this->expectExceptionMessage('Attribute name must contain word characters only.');
        HtmlForm::getAttributeName('content body');
    }

    public function dataGetInputName(): array
    {
        $loginForm = new LoginForm();
        $anonymousForm = new class(new ValidatorFactoryMock()) extends FormModel {
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
     *
     * @param FormModelInterface $form
     * @param string $attribute
     * @param string $expected
     */
    public function testGetInputName(FormModelInterface $form, string $attribute, string $expected): void
    {
        $this->assertSame($expected, HtmlForm::getInputName($form, $attribute));
    }

    public function t1estWrapAttributeNameInvalid(): void
    {
        $this->expectExceptionMessage('Attribute name must contain word characters only.');
        Html::wrapAttributeName('form', 'content body');
    }

    public function t1estWrapAttributeNameEmptyWrapName(): void
    {
        $this->expectException(EmptyWrapNameException::class);
        $this->expectExceptionMessage('Wrap name cannot be empty for tabluar attribute names.');
        Html::wrapAttributeName('', '[0]content');
    }
}
