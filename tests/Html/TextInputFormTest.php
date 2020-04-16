<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Html;

use Yiisoft\Form\Html\TextInputForm;
use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\StubForm;

final class TextInputFormTest extends TestCase
{
    public function testTextInputForm()
    {
        $form = new StubForm();

        $expected = '<input type="text" id="stubform-fieldstring" class="testMe" name="StubForm[fieldString]">';
        $this->assertEquals(
            $expected,
            TextInputForm::create($form, 'fieldString', ['class' => 'testMe'])
        );
    }

    public function testTextInputFormCustomPlaceholder(): void
    {
        $form = new StubForm();

        $expected = 'placeholder="Custom placeholder"';
        $this->assertStringContainsString(
            $expected,
            TextInputForm::create($form, 'fieldString', ['placeholder' => 'Custom placeholder'])
        );
    }

    public function testTextInputFormPlaceholderFillFromModel(): void
    {
        $form = new StubForm();

        $expected  = 'placeholder="Field String"';
        $this->assertStringContainsString(
            $expected,
            TextInputForm::create($form, 'fieldString', ['placeholder' => true])
        );
    }

    public function testTextInputFormPlaceholderFillFromModelTabular()
    {
        $form = new StubForm();

        $expected = 'placeholder="Field String"';
        $this->assertStringContainsString(
            $expected,
            TextInputForm::create($form, '[0]fieldString', ['placeholder' => true])
        );
    }
}
