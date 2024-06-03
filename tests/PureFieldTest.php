<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\PureField;
use Yiisoft\Form\Tests\Support\ThemedPureField;
use Yiisoft\Form\Theme\ThemeContainer;
use Yiisoft\Html\Tag\Button;

final class PureFieldTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
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

    public function testButtonWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::button(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <button type="button"></button>
            </span>
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

    public function testButtonGroupWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::buttonGroup(theme: 'test')->buttons(Button::tag())->render();

        $expected = <<<HTML
            <span>
            <button></button>
            </span>
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

    public function testCheckboxGroupWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::checkbox(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="checkbox" value="1">
            </span>
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

    public function testCheckboxListWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::checkboxList(theme: 'test')
            ->name('test')
            ->itemsFromValues(['a', 'b'])
            ->render();

        $expected = <<<HTML
            <span>
            <div>
            <label><input type="checkbox" name="test[]" value="a"> a</label>
            <label><input type="checkbox" name="test[]" value="b"> b</label>
            </div>
            </span>
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

    public function testDateWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::date(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="date">
            </span>
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

    public function testDateTimeLocalWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::dateTimeLocal(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="datetime-local">
            </span>
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

    public function testEmailWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::email(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="email">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testErrorSummary(): void
    {
        $html = PureField::errorSummary(['key' => ['e1', 'e2']])->render();

        $expected = <<<HTML
            <div>
            <ul>
            <li>e1</li>
            <li>e2</li>
            </ul>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testErrorSummaryWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::errorSummary(['key' => ['e1', 'e2']], theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <ul>
            <li>e1</li>
            <li>e2</li>
            </ul>
            </span>
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

    public function testFieldsetWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::fieldset(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <fieldset>
            </fieldset>
            </span>
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

    public function testFileWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::file(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="file">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testHidden(): void
    {
        $html = PureField::hidden()->render();
        $this->assertSame('<input type="hidden">', $html);
    }

    public function testHiddenWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'inputClass' => 'green',
            ],
        ]);

        $html = ThemedPureField::hidden(theme: 'test')->render();

        $this->assertSame('<input type="hidden" class="green">', $html);
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

    public function testImageWithUrl(): void
    {
        $html = PureField::image('image.png')->render();

        $expected = <<<HTML
            <div>
            <input type="image" src="image.png">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testImageWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::image(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="image">
            </span>
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

    public function testNumberWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::number(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="number">
            </span>
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

    public function testPasswordWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::password(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="password">
            </span>
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

    public function testRadioListWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::radioList(theme: 'test')
            ->name('test')
            ->itemsFromValues(['a', 'b'])
            ->render();

        $expected = <<<HTML
            <span>
            <div>
            <label><input type="radio" name="test" value="a"> a</label>
            <label><input type="radio" name="test" value="b"> b</label>
            </div>
            </span>
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

    public function testRangeWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::range(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="range">
            </span>
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

    public function testResetButtonWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::resetButton(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <button type="reset"></button>
            </span>
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

    public function testSelectWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::select(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <select></select>
            </span>
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

    public function testSubmitButtonWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::submitButton(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <button type="submit"></button>
            </span>
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

    public function testTelephoneWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::telephone(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="tel">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testText(): void
    {
        $html = PureField::text()->render();

        $expected = <<<HTML
            <div>
            <input type="text">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testTextWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::text(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="text">
            </span>
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

    public function testTextareaWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::textarea(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <textarea></textarea>
            </span>
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

    public function testTimeWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::time(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="time">
            </span>
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

    public function testUrlWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedPureField::url(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="url">
            </span>
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

    public function testLabelWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'labelClass' => 'red',
            ],
        ]);

        $html = ThemedPureField::label('hello', theme: 'test')->render();

        $this->assertSame('<label class="red">hello</label>', $html);
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

    public function testHintWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'hintClass' => 'red',
            ],
        ]);

        $html = ThemedPureField::hint('hello', theme: 'test')->render();

        $this->assertSame('<div class="red">hello</div>', $html);
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

    public function testErrorWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'errorClass' => 'red',
            ],
        ]);

        $html = ThemedPureField::error('hello', theme: 'test')->render();

        $this->assertSame('<div class="red">hello</div>', $html);
    }
}
