<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Html;

use Yiisoft\Form\Html\PasswordInputForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;

final class PasswordInputFormTest extends TestCase
{
    public function testPasswordInputForm(): void
    {
        $form = new StubForm();

        $expected = '<input type="password" id="stubform-fieldstring" name="StubForm[fieldString]">';
        $this->assertEquals($expected, PasswordInputForm::create($form, 'fieldString'));

        $expected = '<input type="password" id="stubform-fieldstring" class="test" name="StubForm[fieldString]" value="value">';
        $this->assertEquals(
            $expected,
            PasswordInputForm::create($form, 'fieldString', ['class' => 'test', 'value' => 'value'])
        );
    }
}
