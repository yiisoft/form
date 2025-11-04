<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\PureField;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\PureField\Field;
use Yiisoft\Form\Tests\Support\ThemedField;
use Yiisoft\Form\Theme\ThemeContainer;
use Yiisoft\Html\Tag\Button;

final class FieldTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ThemeContainer::initialize();
    }

    public function testButton(): void
    {
        $html = Field::button()->render();

        $expected = <<<HTML
            <div>
            <button type="button"></button>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testButtonWithContent(): void
    {
        $html = Field::button('Start')->render();

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

        $html = ThemedField::button(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <button type="button"></button>
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testButtonGroup(): void
    {
        $html = Field::buttonGroup()->buttons(Button::tag())->render();

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

        $html = ThemedField::buttonGroup(theme: 'test')->buttons(Button::tag())->render();

        $expected = <<<HTML
            <span>
            <button></button>
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testCheckbox(): void
    {
        $html = Field::checkbox()->render();

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

        $html = ThemedField::checkbox(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="checkbox" value="1">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testCheckboxList(): void
    {
        $html = Field::checkboxList()
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

        $html = ThemedField::checkboxList(theme: 'test')
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
        $html = Field::date()->render();

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

        $html = ThemedField::date(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="date">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testDateTimeLocal(): void
    {
        $html = Field::dateTimeLocal()->render();

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

        $html = ThemedField::dateTimeLocal(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="datetime-local">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testColor(): void
    {
        $html = Field::color()->render();

        $expected = <<<HTML
            <div>
            <input type="color">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testColorWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'containerTag' => 'span',
            ],
        ]);

        $html = ThemedField::color(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="color">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testEmail(): void
    {
        $html = Field::email()->render();

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

        $html = ThemedField::email(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="email">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testErrorSummary(): void
    {
        $html = Field::errorSummary(['key' => ['e1', 'e2']])->render();

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

        $html = ThemedField::errorSummary(['key' => ['e1', 'e2']], theme: 'test')->render();

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
        $html = Field::fieldset()->render();

        $expected = <<<HTML
            <div>
            <fieldset></fieldset>
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

        $html = ThemedField::fieldset(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <fieldset></fieldset>
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testFile(): void
    {
        $html = Field::file()->render();

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

        $html = ThemedField::file(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="file">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testHidden(): void
    {
        $html = Field::hidden()->render();
        $this->assertSame('<input type="hidden">', $html);
    }

    public function testHiddenWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'inputClass' => 'green',
            ],
        ]);

        $html = ThemedField::hidden(theme: 'test')->render();

        $this->assertSame('<input type="hidden" class="green">', $html);
    }

    public function testImage(): void
    {
        $html = Field::image()->render();

        $expected = <<<HTML
            <div>
            <input type="image">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testImageWithUrl(): void
    {
        $html = Field::image('image.png')->render();

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

        $html = ThemedField::image(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="image">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testNumber(): void
    {
        $html = Field::number()->render();

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

        $html = ThemedField::number(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="number">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testPassword(): void
    {
        $html = Field::password()->render();

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

        $html = ThemedField::password(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="password">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testRadioList(): void
    {
        $html = Field::radioList()
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

        $html = ThemedField::radioList(theme: 'test')
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
        $html = Field::range()->render();

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

        $html = ThemedField::range(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="range">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testResetButton(): void
    {
        $html = Field::resetButton()->render();

        $expected = <<<HTML
            <div>
            <button type="reset"></button>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testResetButtonWithContent(): void
    {
        $html = Field::resetButton('Reset')->render();

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

        $html = ThemedField::resetButton(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <button type="reset"></button>
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testSelect(): void
    {
        $html = Field::select()->render();

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

        $html = ThemedField::select(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <select></select>
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testSubmitButton(): void
    {
        $html = Field::submitButton()->render();

        $expected = <<<HTML
            <div>
            <button type="submit"></button>
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testSubmitButtonWithContent(): void
    {
        $html = Field::submitButton('Go')->render();

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

        $html = ThemedField::submitButton(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <button type="submit"></button>
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testTelephone(): void
    {
        $html = Field::telephone()->render();

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

        $html = ThemedField::telephone(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="tel">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testText(): void
    {
        $html = Field::text()->render();

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

        $html = ThemedField::text(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="text">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testTextarea(): void
    {
        $html = Field::textarea()->render();

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

        $html = ThemedField::textarea(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <textarea></textarea>
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testTime(): void
    {
        $html = Field::time()->render();

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

        $html = ThemedField::time(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="time">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testUrl(): void
    {
        $html = Field::url()->render();

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

        $html = ThemedField::url(theme: 'test')->render();

        $expected = <<<HTML
            <span>
            <input type="url">
            </span>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testLabel(): void
    {
        $html = Field::label()->render();
        $this->assertSame('', $html);
    }

    public function testLabelWithContent(): void
    {
        $html = Field::label('test')->render();
        $this->assertSame('<label>test</label>', $html);
    }

    public function testLabelWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'labelClass' => 'red',
            ],
        ]);

        $html = ThemedField::label('hello', theme: 'test')->render();

        $this->assertSame('<label class="red">hello</label>', $html);
    }

    public function testHint(): void
    {
        $html = Field::hint()->render();
        $this->assertSame('', $html);
    }

    public function testHintWithContent(): void
    {
        $html = Field::hint('test')->render();
        $this->assertSame('<div>test</div>', $html);
    }

    public function testHintWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'hintClass' => 'red',
            ],
        ]);

        $html = ThemedField::hint('hello', theme: 'test')->render();

        $this->assertSame('<div class="red">hello</div>', $html);
    }

    public function testError(): void
    {
        $html = Field::error()->render();
        $this->assertSame('', $html);
    }

    public function testErrorWithMessage(): void
    {
        $html = Field::error('test')->render();
        $this->assertSame('<div>test</div>', $html);
    }

    public function testErrorWithTheme(): void
    {
        ThemeContainer::initialize([
            'test' => [
                'errorClass' => 'red',
            ],
        ]);

        $html = ThemedField::error('hello', theme: 'test')->render();

        $this->assertSame('<div class="red">hello</div>', $html);
    }
}
