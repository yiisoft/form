<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Form\Tests\Widget;

use Yiisoft\Yii\Form\Tests\TestCase;
use Yiisoft\Yii\Form\Tests\Stub\PersonalForm;
use Yiisoft\Yii\Form\Widget\PasswordInput;

final class PasswordInputTest extends TestCase
{
    public function testPasswordInput(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="password" id="personalform-password" name="PersonalForm[password]" placeholder="Password">
HTML;
        $html = PasswordInput::widget()
            ->config($data, 'password')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testPasswordInputOptions(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="password" id="personalform-password" class="customClass" name="PersonalForm[password]" placeholder="Password">
HTML;
        $html = PasswordInput::widget()
            ->config($data, 'password', ['class' => 'customClass'])
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testPasswordInputAutofocus(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="password" id="personalform-password" name="PersonalForm[password]" autofocus placeholder="Password">
HTML;
        $html = PasswordInput::widget()
            ->config($data, 'password')
            ->autofocus()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testPasswordInputDisabled(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="password" id="personalform-password" name="PersonalForm[password]" disabled placeholder="Password">
HTML;
        $html = PasswordInput::widget()
            ->config($data, 'password')
            ->disabled()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testPasswordInputForm(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="password" id="personalform-password" name="PersonalForm[password]" form="form-id" placeholder="Password">
HTML;
        $html = PasswordInput::widget()
            ->config($data, 'password')
            ->form('form-id')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testPasswordInputMinLength(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="password" id="personalform-password" name="PersonalForm[password]" minlength="8" placeholder="Password">
HTML;
        $html = PasswordInput::widget()
            ->config($data, 'password')
            ->minlength(8)
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testPasswordInputMaxLength(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="password" id="personalform-password" name="PersonalForm[password]" maxlength="16" placeholder="Password">
HTML;
        $html = PasswordInput::widget()
            ->config($data, 'password')
            ->maxlength(16)
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testPasswordInputNoPlaceholder(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="password" id="personalform-password" name="PersonalForm[password]">
HTML;
        $html = PasswordInput::widget()
            ->config($data, 'password')
            ->noPlaceholder()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testPasswordInputPattern(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="password" id="personalform-password" name="PersonalForm[password]" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters." pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Password">
HTML;
        $html = PasswordInput::widget()
            ->config($data, 'password')
            ->pattern('(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}')
            ->title('Must contain at least one number and one uppercase and lowercase letter, and at least 8 or ' .
                'more characters.')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testPasswordInputPlaceholder(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="password" id="personalform-password" name="PersonalForm[password]" placeholder="Custom placeholder">
HTML;
        $html = PasswordInput::widget()
            ->config($data, 'password')
            ->placeholder('Custom placeholder')
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testPasswordInputReadOnly(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="password" id="personalform-password" name="PersonalForm[password]" readonly placeholder="Password">
HTML;
        $html = PasswordInput::widget()
            ->config($data, 'password')
            ->readOnly()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testPasswordInputRequired(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="password" id="personalform-password" name="PersonalForm[password]" required placeholder="Password">
HTML;
        $html = PasswordInput::widget()
            ->config($data, 'password')
            ->required()
            ->run();
        $this->assertEquals($expected, $html);
    }

    public function testPasswordInputTabIndex(): void
    {
        $data = new PersonalForm();

        $expected = <<<'HTML'
<input type="password" id="personalform-password" name="PersonalForm[password]" tabindex="2" placeholder="Password">
HTML;
        $html = PasswordInput::widget()
            ->config($data, 'password')
            ->tabindex(2)
            ->run();
        $this->assertEquals($expected, $html);
    }
}
