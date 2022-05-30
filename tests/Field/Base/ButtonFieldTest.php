<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Base;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\Support\StubButtonField;
use Yiisoft\Html\Tag\Button as ButtonTag;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class ButtonFieldTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testBase(): void
    {
        $result = StubButtonField::widget()
            ->content('Start')
            ->render();

        $expected = <<<HTML
                    <div>
                    <button type="button">Start</button>
                    </div>
                    HTML;

        $this->assertSame($expected, $result);
    }

    public function testButton(): void
    {
        $result = StubButtonField::widget()
            ->button(
                ButtonTag::tag()->content('Start')->class('primary')
            )
            ->render();

        $expected = <<<HTML
                    <div>
                    <button type="button" class="primary">Start</button>
                    </div>
                    HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddButtonAttributes(): void
    {
        $result = StubButtonField::widget()
            ->addButtonAttributes([
                'data-key' => 'main',
                'class' => 'primary',
            ])
            ->addButtonAttributes([
                'aria-label' => 'test',
            ])
            ->render();

        $expected = <<<HTML
                    <div>
                    <button type="button" class="primary" data-key="main" aria-label="test"></button>
                    </div>
                    HTML;

        $this->assertSame($expected, $result);
    }

    public function testButtonAttributes(): void
    {
        $result = StubButtonField::widget()
            ->buttonAttributes([
                'data-key' => 'main',
                'class' => 'primary',
            ])
            ->buttonAttributes([
                'class' => 'red',
            ])
            ->render();

        $expected = <<<HTML
                    <div>
                    <button type="button" class="red"></button>
                    </div>
                    HTML;

        $this->assertSame($expected, $result);
    }

    public function dataButtonId(): array
    {
        return [
            ['', null],
            [' id="main"', 'main'],
        ];
    }

    /**
     * @dataProvider dataButtonId
     */
    public function testButtonId(string $expectedId, ?string $id): void
    {
        $result = StubButtonField::widget()
            ->buttonId($id)
            ->render();

        $expected = <<<HTML
            <div>
            <button type="button"$expectedId></button>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function dataName(): array
    {
        return [
            ['', null],
            [' name="go-btn"', 'go-btn'],
        ];
    }

    /**
     * @dataProvider dataName
     */
    public function testName(string $expectedNameAttribute, ?string $name): void
    {
        $result = StubButtonField::widget()
            ->name($name)
            ->render();

        $expected = <<<HTML
            <div>
            <button type="button"$expectedNameAttribute></button>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAriaDescribedBy(): void
    {
        $result = StubButtonField::widget()
            ->ariaDescribedBy('hint')
            ->render();

        $expected = <<<HTML
                    <div>
                    <button type="button" aria-describedby="hint"></button>
                    </div>
                    HTML;

        $this->assertSame($expected, $result);
    }

    public function testAriaLabel(): void
    {
        $result = StubButtonField::widget()
            ->ariaLabel('test')
            ->render();

        $expected = <<<HTML
                    <div>
                    <button type="button" aria-label="test"></button>
                    </div>
                    HTML;

        $this->assertSame($expected, $result);
    }

    public function testAutofocus(): void
    {
        $result = StubButtonField::widget()
            ->autofocus()
            ->render();

        $expected = <<<HTML
                    <div>
                    <button type="button" autofocus></button>
                    </div>
                    HTML;

        $this->assertSame($expected, $result);
    }

    public function testTabIndex(): void
    {
        $result = StubButtonField::widget()
            ->tabIndex(5)
            ->render();

        $expected = <<<HTML
                    <div>
                    <button type="button" tabindex="5"></button>
                    </div>
                    HTML;

        $this->assertSame($expected, $result);
    }

    public function testDisabled(): void
    {
        $result = StubButtonField::widget()
            ->disabled()
            ->render();

        $expected = <<<HTML
                    <div>
                    <button type="button" disabled></button>
                    </div>
                    HTML;

        $this->assertSame($expected, $result);
    }

    public function testForm(): void
    {
        $result = StubButtonField::widget()
            ->form('Post')
            ->render();

        $expected = <<<HTML
                    <div>
                    <button type="button" form="Post"></button>
                    </div>
                    HTML;

        $this->assertSame($expected, $result);
    }

    public function dataAddButtonClass(): array
    {
        return [
            [' class="main"', []],
            [' class="main"', ['main']],
            [' class="main bold"', ['bold']],
            [' class="main italic bold"', ['italic bold']],
            [' class="main italic bold"', ['italic', 'bold']],
        ];
    }

    /**
     * @dataProvider dataAddButtonClass
     *
     * @param string[] $class
     */
    public function testAddButtonClass(string $expectedClassAttribute, array $class): void
    {
        $result = StubButtonField::widget()
            ->addButtonClass('main')
            ->addButtonClass(...$class)
            ->render();

        $expected = <<<HTML
            <div>
            <button type="button"$expectedClassAttribute></button>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function dataAddButtonNewClass(): array
    {
        return [
            ['', null],
            [' class', ''],
            [' class="red"', 'red'],
        ];
    }

    /**
     * @dataProvider dataAddButtonNewClass
     */
    public function testAddButtonNewClass(string $expectedClassAttribute, ?string $class): void
    {
        $result = StubButtonField::widget()
            ->addButtonClass($class)
            ->render();

        $expected = <<<HTML
            <div>
            <button type="button"$expectedClassAttribute></button>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function dataButtonClass(): array
    {
        return [
            ['', []],
            ['', [null]],
            [' class', ['']],
            [' class="main"', ['main']],
            [' class="main bold"', ['main bold']],
            [' class="main bold"', ['main', 'bold']],
        ];
    }

    /**
     * @dataProvider dataButtonClass
     *
     * @param string[] $class
     */
    public function testButtonClass(string $expectedClassAttribute, array $class): void
    {
        $result = StubButtonField::widget()
            ->buttonClass('red')
            ->buttonClass(...$class)
            ->render();

        $expected = <<<HTML
            <div>
            <button type="button"$expectedClassAttribute></button>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = StubButtonField::widget();

        $this->assertNotSame($field, $field->button(null));
        $this->assertNotSame($field, $field->buttonAttributes([]));
        $this->assertNotSame($field, $field->addButtonAttributes([]));
        $this->assertNotSame($field, $field->buttonId(null));
        $this->assertNotSame($field, $field->addButtonClass());
        $this->assertNotSame($field, $field->buttonClass());
        $this->assertNotSame($field, $field->name(null));
        $this->assertNotSame($field, $field->ariaDescribedBy(null));
        $this->assertNotSame($field, $field->ariaLabel(null));
        $this->assertNotSame($field, $field->autofocus());
        $this->assertNotSame($field, $field->tabIndex(null));
        $this->assertNotSame($field, $field->disabled());
        $this->assertNotSame($field, $field->form(null));
    }
}
