<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\PureField;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class PureFieldTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize();
    }

    public function testButton(): void
    {
        $html = PureField::button()->render();

        $expected = <<<HTML
            <div>
            <button type="button"></button>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testButtonWithContent(): void
    {
        $html = PureField::button('Start')->render();

        $expected = <<<HTML
            <div>
            <button type="button">Start</button>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testButtonGroup(): void
    {
        $html = PureField::buttonGroup()->buttons(Button::tag())->render();

        $expected = <<<HTML
            <div>
            <button></button>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testCheckbox(): void
    {
        $html = PureField::checkbox()->render();

        $expected = <<<HTML
            <div>
            <input type="checkbox" value="1">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testCheckboxList(): void
    {
        $html = PureField::checkboxList()
            ->name('test')
            ->itemsFromValues(['a', 'b'])
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <label><input type="checkbox" name="test[]" value="a"> a</label>
            <label><input type="checkbox" name="test[]" value="b"> b</label>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testDate(): void
    {
        $html = PureField::date()->render();

        $expected = <<<HTML
            <div>
            <input type="date">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testDateTime(): void
    {
        $html = PureField::dateTime()->render();

        $expected = <<<HTML
            <div>
            <input type="datetime">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testDateTimeLocal(): void
    {
        $html = PureField::dateTimeLocal()->render();

        $expected = <<<HTML
            <div>
            <input type="datetime-local">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testEmail(): void
    {
        $html = PureField::email()->render();

        $expected = <<<HTML
            <div>
            <input type="email">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testFieldset(): void
    {
        $html = PureField::fieldset()->render();

        $expected = <<<HTML
            <div>
            <fieldset>
            </fieldset>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testFile(): void
    {
        $html = PureField::file()->render();

        $expected = <<<HTML
            <div>
            <input type="file">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testImage(): void
    {
        $html = PureField::image()->render();

        $expected = <<<HTML
            <div>
            <input type="image">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testNumber(): void
    {
        $html = PureField::number()->render();

        $expected = <<<HTML
            <div>
            <input type="number">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testPassword(): void
    {
        $html = PureField::password()->render();

        $expected = <<<HTML
            <div>
            <input type="password">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testRadioList(): void
    {
        $html = PureField::radioList()
            ->name('test')
            ->itemsFromValues(['a', 'b'])
            ->render();

        $expected = <<<HTML
            <div>
            <div>
            <label><input type="radio" name="test" value="a"> a</label>
            <label><input type="radio" name="test" value="b"> b</label>
            </div>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testRange(): void
    {
        $html = PureField::range()->render();

        $expected = <<<HTML
            <div>
            <input type="range">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testResetButton(): void
    {
        $html = PureField::resetButton()->render();

        $expected = <<<HTML
            <div>
            <button type="reset"></button>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testResetButtonWithContent(): void
    {
        $html = PureField::resetButton('Reset')->render();

        $expected = <<<HTML
            <div>
            <button type="reset">Reset</button>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testSelect(): void
    {
        $html = PureField::select()->render();

        $expected = <<<HTML
            <div>
            <select></select>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testSubmitButton(): void
    {
        $html = PureField::submitButton()->render();

        $expected = <<<HTML
            <div>
            <button type="submit"></button>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testSubmitButtonWithContent(): void
    {
        $html = PureField::submitButton('Go')->render();

        $expected = <<<HTML
            <div>
            <button type="submit">Go</button>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testTelephone(): void
    {
        $html = PureField::telephone()->render();

        $expected = <<<HTML
            <div>
            <input type="tel">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testTextarea(): void
    {
        $html = PureField::textarea()->render();

        $expected = <<<HTML
            <div>
            <textarea></textarea>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testTime(): void
    {
        $html = PureField::time()->render();

        $expected = <<<HTML
            <div>
            <input type="time">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testUrl(): void
    {
        $html = PureField::url()->render();

        $expected = <<<HTML
            <div>
            <input type="url">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testLabel(): void
    {
        $html = PureField::label()->render();
        $this->assertSame('', $html);
    }

    public function testLabelWithContent(): void
    {
        $html = PureField::label('test')->render();
        $this->assertSame('<label>test</label>', $html);
    }

    public function testHint(): void
    {
        $html = PureField::hint()->render();
        $this->assertSame('', $html);
    }

    public function testHintWithContent(): void
    {
        $html = PureField::hint('test')->render();
        $this->assertSame('<div>test</div>', $html);
    }

    public function testError(): void
    {
        $html = PureField::error()->render();
        $this->assertSame('', $html);
    }

    public function testErrorWithMessage(): void
    {
        $html = PureField::error('test')->render();
        $this->assertSame('<div>test</div>', $html);
    }
}
