<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use Yiisoft\Form\Tests\TestCase;
use Yiisoft\Form\Tests\Stub\PersonalForm;
use Yiisoft\Form\Widget\TextInput;

final class TextInputTest extends TestCase
{
    public function testTextInput(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]" placeholder="Name">
HTML;
        $html = TextInput::widget()
            ->config($data, 'name')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextInputOptions(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" class="customClass" name="PersonalForm[name]" placeholder="Name">
HTML;
        $html = TextInput::widget()
            ->config($data, 'name', ['class' => 'customClass'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextInputAutofocus(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]" autofocus placeholder="Name">
HTML;
        $html = TextInput::widget()
            ->config($data, 'name')
            ->autofocus()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextInputDisabled(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]" disabled placeholder="Name">
HTML;
        $html = TextInput::widget()
            ->config($data, 'name')
            ->disabled()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextInputForm(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]" form="form-id" placeholder="Name">
HTML;
        $html = TextInput::widget()
            ->config($data, 'name')
            ->form('form-id')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextInputMinLength(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]" minlength="2" placeholder="Name">
HTML;
        $html = TextInput::widget()
            ->config($data, 'name')
            ->minlength(2)
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextInputMaxLength(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]" maxlength="10" placeholder="Name">
HTML;
        $html = TextInput::widget()
            ->config($data, 'name')
            ->maxlength(10)
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextInputNoPlaceholder(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]">
HTML;
        $html = TextInput::widget()
            ->config($data, 'name')
            ->noPlaceholder()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextInputPattern(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]" title="Only accepts uppercase and lowercase letters." pattern="[A-Za-z]" placeholder="Name">
HTML;
        $html = TextInput::widget()
            ->config($data, 'name')
            ->pattern('[A-Za-z]')
            ->title('Only accepts uppercase and lowercase letters.')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextInputPlaceholder(): void
    {
        $data = new PersonalForm();

        $expected = 'placeholder="Custom placeholder"';
        $html = TextInput::widget()
            ->config($data, 'name')
            ->placeholder('Custom placeholder')
            ->run();
        $this->assertStringContainsString($expected, $html);

        $expected = 'placeholder="Name"';
        $html = TextInput::widget()
            ->config($data, '[0]name')
            ->run();
        $this->assertStringContainsString($expected, $html);
    }

    public function testTextInputReadOnly(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]" readonly placeholder="Name">
HTML;
        $html = TextInput::widget()
            ->config($data, 'name')
            ->readOnly()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextInputsize(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]" size="10" placeholder="Name">
HTML;
        $html = TextInput::widget()
            ->config($data, 'name')
            ->size(10)
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextInputRequired(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]" required placeholder="Name">
HTML;
        $html = TextInput::widget()
            ->config($data, 'name')
            ->required()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextInputTabIndex(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]" tabindex="0" placeholder="Name">
HTML;
        $html = TextInput::widget()
            ->config($data, 'name')
            ->tabIndex()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testTextInputSpellCheck(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="text" id="personalform-name" name="PersonalForm[name]" spellcheck placeholder="Name">
HTML;
        $html = TextInput::widget()
            ->config($data, 'name')
            ->spellcheck()
            ->run();
        $this->assertEquals($expected, $html);
    }
}
