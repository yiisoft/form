<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\Password;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class PasswordTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $inputData = new PureInputData(
            name: 'PasswordForm[old]',
            value: '',
            label: 'Old password',
            hint: 'Enter your old password.',
            id: 'passwordform-old',
        );

        $result = Password::widget()
            ->inputData($inputData)
            ->render();

        $expected = <<<HTML
            <div>
            <label for="passwordform-old">Old password</label>
            <input type="password" id="passwordform-old" name="PasswordForm[old]" value>
            <div>Enter your old password.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testMaxlength(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->maxlength(9)
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" maxlength="9">',
            $result
        );
    }

    public function testMinlength(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->minlength(3)
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" minlength="3">',
            $result
        );
    }

    public function testPattern(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->pattern('\d+')
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" pattern="\d+">',
            $result
        );
    }

    public function testReadonly(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->readonly()
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" readonly>',
            $result
        );
    }

    public function testRequired(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->required()
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" required>',
            $result
        );
    }

    public function testDisabled(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->disabled()
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" disabled>',
            $result
        );
    }

    public function testAriaDescribedBy(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->ariaDescribedBy('hint')
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" aria-describedby="hint">',
            $result
        );
    }

    public function testAriaLabel(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->ariaLabel('test')
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" aria-label="test">',
            $result
        );
    }

    public function testAutofocus(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->autofocus()
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" autofocus>',
            $result
        );
    }

    public function testTabIndex(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->tabIndex(4)
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" tabindex="4">',
            $result
        );
    }

    public function testSize(): void
    {
        $result = Password::widget()
            ->name('newPassword')
            ->hideLabel()
            ->useContainer(false)
            ->size(7)
            ->render();

        $this->assertSame(
            '<input type="password" name="newPassword" size="7">',
            $result
        );
    }

    public function testInvalidValue(): void
    {
        $widget = Password::widget()->value(42);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Password field requires a string or null value.');
        $widget->render();
    }
}
