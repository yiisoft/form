<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\SubmitButton;
use Yiisoft\Form\Tests\Support\AssertTrait;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class SubmitButtonTest extends TestCase
{
    use AssertTrait;

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testBase(): void
    {
        $result = SubmitButton::widget()
            ->content('Go!')
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <button type="submit">Go!</button>
            </div>
            HTML,
            $result
        );
    }

    public function testButton(): void
    {
        $button = Button::tag()
            ->class('red')
            ->content('Go!');

        $result = SubmitButton::widget()
            ->button($button)
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <button type="submit" class="red">Go!</button>
            </div>
            HTML,
            $result
        );
    }

    public function dataDisabled(): array
    {
        return [
            ['<button type="submit"></button>', null],
            ['<button type="submit"></button>', false],
            ['<button type="submit" disabled></button>', true],
        ];
    }

    /**
     * @dataProvider dataDisabled
     */
    public function testDisabled(string $expected, ?bool $disabled): void
    {
        $result = SubmitButton::widget()
            ->disabled($disabled)
            ->useContainer(false)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testWithLabel(): void
    {
        $result = SubmitButton::widget()
            ->content('Go!')
            ->label('Click here!')
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <label>Click here!</label>
            <button type="submit">Go!</button>
            </div>
            HTML,
            $result
        );
    }

    public function testWithHint(): void
    {
        $result = SubmitButton::widget()
            ->content('Go!')
            ->hint('Click here!')
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <button type="submit">Go!</button>
            <div>Click here!</div>
            </div>
            HTML,
            $result
        );
    }

    public function testWithError(): void
    {
        $result = SubmitButton::widget()
            ->content('Go!')
            ->error('error message')
            ->render();

        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <button type="submit">Go!</button>
            <div>error message</div>
            </div>
            HTML,
            $result
        );
    }

    public function testImmutability(): void
    {
        $widget = SubmitButton::widget();

        $this->assertNotSame($widget, $widget->button(null));
        $this->assertNotSame($widget, $widget->attributes([]));
        $this->assertNotSame($widget, $widget->replaceAttributes([]));
        $this->assertNotSame($widget, $widget->disabled());
        $this->assertNotSame($widget, $widget->form(null));
    }
}
