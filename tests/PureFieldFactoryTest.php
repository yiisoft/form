<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\PureFieldFactory;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Html\Tag\Button;

final class PureFieldFactoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ThemeContainer::initialize();
    }

    public function testButton(): void
    {
        $html = (new PureFieldFactory())->button()->render();

        $expected = <<<HTML
            <div>
            <button type="button"></button>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testButtonWithContent(): void
    {
        $html = (new PureFieldFactory())->button('Start')->render();

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

        $html = (new PureFieldFactory('default'))->button(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <button type="button"></button>
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testButtonGroup(): void
    {
        $html = (new PureFieldFactory())->buttonGroup()->buttons(Button::tag())->render();

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

        $html = (new PureFieldFactory('default'))->buttonGroup(theme: 'test')->buttons(Button::tag())->render();

        $expected = <<<HTML
            <span>
            <button></button>
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testCheckbox(): void
    {
        $html = (new PureFieldFactory())->checkbox()->render();

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

        $html = (new PureFieldFactory('default'))->checkbox(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="checkbox" value="1">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testCheckboxList(): void
    {
        $html = (new PureFieldFactory())->checkboxList()
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

        $html = (new PureFieldFactory('default'))->checkboxList(theme: 'test')
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
        $html = (new PureFieldFactory())->date()->render();

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

        $html = (new PureFieldFactory('default'))->date(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="date">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testDateTime(): void
    {
        $html = (new PureFieldFactory())->dateTime()->render();

        $expected = <<<HTML
            <div>
            <input type="datetime">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testDateTimeWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = (new PureFieldFactory('default'))->dateTime(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="datetime">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testDateTimeLocal(): void
    {
        $html = (new PureFieldFactory())->dateTimeLocal()->render();

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

        $html = (new PureFieldFactory('default'))->dateTimeLocal(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="datetime-local">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testEmail(): void
    {
        $html = (new PureFieldFactory())->email()->render();

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

        $html = (new PureFieldFactory('default'))->email(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="email">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testErrorSummary(): void
    {
        $html = (new PureFieldFactory())->errorSummary(['key' => ['e1', 'e2']])->render();

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

        $html = (new PureFieldFactory('default'))->errorSummary(['key' => ['e1', 'e2']], theme: 'test')->render();

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
        $html = (new PureFieldFactory())->fieldset()->render();

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

        $html = (new PureFieldFactory('default'))->fieldset(theme: 'test')->render();

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
        $html = (new PureFieldFactory())->file()->render();

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

        $html = (new PureFieldFactory('default'))->file(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="file">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testHidden(): void
    {
        $html = (new PureFieldFactory())->hidden()->render();
        $this->assertSame('<input type="hidden">', $html);
    }

    public function testHiddenWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'inputClass' => 'green',
            ],
        ]);

        $html = (new PureFieldFactory('default'))->hidden(theme: 'test')->render();

        $this->assertSame('<input type="hidden" class="green">', $html);
    }

    public function testImage(): void
    {
        $html = (new PureFieldFactory())->image()->render();

        $expected = <<<HTML
            <div>
            <input type="image">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testImageWithUrl(): void
    {
        $html = (new PureFieldFactory())->image('image.png')->render();

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

        $html = (new PureFieldFactory('default'))->image(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="image">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testNumber(): void
    {
        $html = (new PureFieldFactory())->number()->render();

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

        $html = (new PureFieldFactory('default'))->number(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="number">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testPassword(): void
    {
        $html = (new PureFieldFactory())->password()->render();

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

        $html = (new PureFieldFactory('default'))->password(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="password">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testRadioList(): void
    {
        $html = (new PureFieldFactory())->radioList()
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

        $html = (new PureFieldFactory('default'))->radioList(theme: 'test')
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
        $html = (new PureFieldFactory())->range()->render();

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

        $html = (new PureFieldFactory('default'))->range(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="range">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testResetButton(): void
    {
        $html = (new PureFieldFactory())->resetButton()->render();

        $expected = <<<HTML
            <div>
            <button type="reset"></button>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testResetButtonWithContent(): void
    {
        $html = (new PureFieldFactory())->resetButton('Reset')->render();

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

        $html = (new PureFieldFactory('default'))->resetButton(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <button type="reset"></button>
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testSelect(): void
    {
        $html = (new PureFieldFactory())->select()->render();

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

        $html = (new PureFieldFactory('default'))->select(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <select></select>
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testSubmitButton(): void
    {
        $html = (new PureFieldFactory())->submitButton()->render();

        $expected = <<<HTML
            <div>
            <button type="submit"></button>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testSubmitButtonWithContent(): void
    {
        $html = (new PureFieldFactory())->submitButton('Go')->render();

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

        $html = (new PureFieldFactory('default'))->submitButton(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <button type="submit"></button>
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testTelephone(): void
    {
        $html = (new PureFieldFactory())->telephone()->render();

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

        $html = (new PureFieldFactory('default'))->telephone(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="tel">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testText(): void
    {
        $html = (new PureFieldFactory())->text()->render();

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

        $html = (new PureFieldFactory('default'))->text(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="text">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testTextarea(): void
    {
        $html = (new PureFieldFactory())->textarea()->render();

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

        $html = (new PureFieldFactory('default'))->textarea(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <textarea></textarea>
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testTime(): void
    {
        $html = (new PureFieldFactory())->time()->render();

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

        $html = (new PureFieldFactory('default'))->time(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="time">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testUrl(): void
    {
        $html = (new PureFieldFactory())->url()->render();

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

        $html = (new PureFieldFactory('default'))->url(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="url">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testLabel(): void
    {
        $html = (new PureFieldFactory())->label()->render();
        $this->assertSame('', $html);
    }

    public function testLabelWithContent(): void
    {
        $html = (new PureFieldFactory())->label('test')->render();
        $this->assertSame('<label>test</label>', $html);
    }

    public function testLabelWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'labelClass' => 'red',
            ],
        ]);

        $html = (new PureFieldFactory('default'))->label('hello', theme: 'test')->render();

        $this->assertSame('<label class="red">hello</label>', $html);
    }

    public function testHint(): void
    {
        $html = (new PureFieldFactory())->hint()->render();
        $this->assertSame('', $html);
    }

    public function testHintWithContent(): void
    {
        $html = (new PureFieldFactory())->hint('test')->render();
        $this->assertSame('<div>test</div>', $html);
    }

    public function testHintWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'hintClass' => 'red',
            ],
        ]);

        $html = (new PureFieldFactory('default'))->hint('hello', theme: 'test')->render();

        $this->assertSame('<div class="red">hello</div>', $html);
    }

    public function testError(): void
    {
        $html = (new PureFieldFactory())->error()->render();
        $this->assertSame('', $html);
    }

    public function testErrorWithMessage(): void
    {
        $html = (new PureFieldFactory())->error('test')->render();
        $this->assertSame('<div>test</div>', $html);
    }

    public function testErrorWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'errorClass' => 'red',
            ],
        ]);

        $html = (new PureFieldFactory('default'))->error('hello', theme: 'test')->render();

        $this->assertSame('<div class="red">hello</div>', $html);
    }
}
