<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Part;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\YiisoftYiiValidatableForm\FormModelInputData;
use Yiisoft\Form\Field\Part\Label;
use Yiisoft\Form\Tests\Support\Form\LabelForm;
use Yiisoft\Form\Tests\Support\StringableObject;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class LabelTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $result = Label::widget()
            ->inputData(new FormModelInputData(new LabelForm(), 'name'))
            ->render();

        $this->assertSame('<label for="labelform-name">Name</label>', $result);
    }

    public function testAddAttributes(): void
    {
        $result = Label::widget()
            ->inputData(new FormModelInputData(new LabelForm(), 'name'))
            ->addAttributes(['class' => 'red'])
            ->addAttributes(['data-number' => 18])
            ->render();

        $this->assertSame('<label class="red" data-number="18" for="labelform-name">Name</label>', $result);
    }

    public function testAttributes(): void
    {
        $result = Label::widget()
            ->inputData(new FormModelInputData(new LabelForm(), 'name'))
            ->attributes(['class' => 'red'])
            ->attributes(['data-number' => 18])
            ->render();

        $this->assertSame('<label data-number="18" for="labelform-name">Name</label>', $result);
    }

    public function dataId(): array
    {
        return [
            ['', null],
            [' id="main"', 'main'],
        ];
    }

    /**
     * @dataProvider dataId
     */
    public function testId(string $expectedId, ?string $id): void
    {
        $result = Label::widget()
            ->inputData(new FormModelInputData(new LabelForm(), 'name'))
            ->id($id)
            ->render();

        $expected = '<label' . $expectedId . ' for="labelform-name">Name</label>';

        $this->assertSame($expected, $result);
    }

    public function dataAddClass(): array
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
     * @dataProvider dataAddClass
     *
     * @param string[] $class
     */
    public function testAddClass(string $expectedClassAttribute, array $class): void
    {
        $result = Label::widget()
            ->inputData(new FormModelInputData(new LabelForm(), 'name'))
            ->addClass('main')
            ->addClass(...$class)
            ->render();

        $expected = '<label' . $expectedClassAttribute . ' for="labelform-name">Name</label>';

        $this->assertSame($expected, $result);
    }

    public function dataAddNewClass(): array
    {
        return [
            ['', null],
            [' class', ''],
            [' class="red"', 'red'],
        ];
    }

    /**
     * @dataProvider dataAddNewClass
     */
    public function testAddNewClass(string $expectedClassAttribute, ?string $class): void
    {
        $result = Label::widget()
            ->inputData(new FormModelInputData(new LabelForm(), 'name'))
            ->addClass($class)
            ->render();

        $expected = '<label' . $expectedClassAttribute . ' for="labelform-name">Name</label>';

        $this->assertSame($expected, $result);
    }

    public function dataClass(): array
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
     * @dataProvider dataClass
     *
     * @param string[] $class
     */
    public function testClass(string $expectedClassAttribute, array $class): void
    {
        $result = Label::widget()
            ->inputData(new FormModelInputData(new LabelForm(), 'name'))
            ->class('red')
            ->class(...$class)
            ->render();

        $expected = '<label' . $expectedClassAttribute . ' for="labelform-name">Name</label>';

        $this->assertSame($expected, $result);
    }

    public function testDoNotSetFor(): void
    {
        $result = Label::widget()
            ->inputData(new FormModelInputData(new LabelForm(), 'name'))
            ->setFor(false)
            ->render();

        $this->assertSame('<label>Name</label>', $result);
    }

    public function customFor(): void
    {
        $result = Label::widget()
            ->inputData(new FormModelInputData(new LabelForm(), 'name'))
            ->forId('MyID')
            ->render();

        $this->assertSame('<label for="MyID">Name</label>', $result);
    }

    public function testDoNotUseInputId(): void
    {
        $result = Label::widget()
            ->inputData(new FormModelInputData(new LabelForm(), 'name'))
            ->useInputId(false)
            ->render();

        $this->assertSame('<label>Name</label>', $result);
    }

    public function testCustomForWithDoNotUseInputId(): void
    {
        $result = Label::widget()
            ->inputData(new FormModelInputData(new LabelForm(), 'name'))
            ->useInputId(false)
            ->forId('MyID')
            ->render();

        $this->assertSame('<label for="MyID">Name</label>', $result);
    }

    public function testCustomContent(): void
    {
        $result = Label::widget()
            ->inputData(new FormModelInputData(new LabelForm(), 'name'))
            ->content('Your name')
            ->render();

        $this->assertSame('<label for="labelform-name">Your name</label>', $result);
    }

    public function testEmptyContent(): void
    {
        $result = Label::widget()
            ->inputData(new FormModelInputData(new LabelForm(), 'name'))
            ->content('')
            ->render();

        $this->assertSame('', $result);
    }

    public function testContentAsStringableObject(): void
    {
        $result = Label::widget()
            ->inputData(new FormModelInputData(new LabelForm(), 'name'))
            ->content(new StringableObject('Your name'))
            ->render();

        $this->assertSame('<label for="labelform-name">Your name</label>', $result);
    }

    public function testEncode(): void
    {
        $result = Label::widget()
            ->inputData(new FormModelInputData(new LabelForm(), 'name'))
            ->content('Your name >')
            ->render();

        $this->assertSame('<label for="labelform-name">Your name &gt;</label>', $result);
    }

    public function testWithoutEncode(): void
    {
        $result = Label::widget()
            ->inputData(new FormModelInputData(new LabelForm(), 'name'))
            ->content('<b>Name</b>')
            ->encode(false)
            ->render();

        $this->assertSame('<label for="labelform-name"><b>Name</b></label>', $result);
    }

    public function testImmutability(): void
    {
        $label = Label::widget();

        $this->assertNotSame($label, $label->attributes([]));
        $this->assertNotSame($label, $label->addAttributes([]));
        $this->assertNotSame($label, $label->setFor(true));
        $this->assertNotSame($label, $label->forId(null));
        $this->assertNotSame($label, $label->useInputId(true));
        $this->assertNotSame($label, $label->content(null));
        $this->assertNotSame($label, $label->encode(true));
    }
}
