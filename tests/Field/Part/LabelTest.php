<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Part;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\Part\Label;
use Yiisoft\Form\Tests\Support\StringableObject;
use Yiisoft\Form\ThemeContainer;

final class LabelTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $inputData = new PureInputData(label: 'Name', id: 'id-test');

        $result = Label::widget()->inputData($inputData)->render();

        $this->assertSame('<label for="id-test">Name</label>', $result);
    }

    public function testAddAttributes(): void
    {
        $result = Label::widget()
            ->content('Name')
            ->addAttributes(['class' => 'red'])
            ->addAttributes(['data-number' => 18])
            ->render();

        $this->assertSame('<label class="red" data-number="18">Name</label>', $result);
    }

    public function testAttributes(): void
    {
        $result = Label::widget()
            ->content('Name')
            ->attributes(['class' => 'red'])
            ->attributes(['data-number' => 18])
            ->render();

        $this->assertSame('<label data-number="18">Name</label>', $result);
    }

    public static function dataId(): array
    {
        return [
            ['', null],
            [' id="main"', 'main'],
        ];
    }

    #[DataProvider('dataId')]
    public function testId(string $expectedId, ?string $id): void
    {
        $result = Label::widget()
            ->content('Name')
            ->id($id)
            ->render();

        $expected = '<label' . $expectedId . '>Name</label>';

        $this->assertSame($expected, $result);
    }

    public static function dataAddClass(): array
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
     * @param string[] $class
     */
    #[DataProvider('dataAddClass')]
    public function testAddClass(string $expectedClassAttribute, array $class): void
    {
        $result = Label::widget()
            ->content('Name')
            ->addClass('main')
            ->addClass(...$class)
            ->render();

        $expected = '<label' . $expectedClassAttribute . '>Name</label>';

        $this->assertSame($expected, $result);
    }

    public static function dataAddNewClass(): array
    {
        return [
            ['', null],
            [' class', ''],
            [' class="red"', 'red'],
        ];
    }

    #[DataProvider('dataAddNewClass')]
    public function testAddNewClass(string $expectedClassAttribute, ?string $class): void
    {
        $result = Label::widget()
            ->content('Name')
            ->addClass($class)
            ->render();

        $expected = '<label' . $expectedClassAttribute . '>Name</label>';

        $this->assertSame($expected, $result);
    }

    public static function dataClass(): array
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
     * @param string[] $class
     */
    #[DataProvider('dataClass')]
    public function testClass(string $expectedClassAttribute, array $class): void
    {
        $result = Label::widget()
            ->content('Name')
            ->class('red')
            ->class(...$class)
            ->render();

        $expected = '<label' . $expectedClassAttribute . '>Name</label>';

        $this->assertSame($expected, $result);
    }

    public function testDoNotSetFor(): void
    {
        $result = Label::widget()
            ->content('Name')
            ->setFor(false)
            ->render();

        $this->assertSame('<label>Name</label>', $result);
    }

    public function customFor(): void
    {
        $inputData = new PureInputData(label: 'Name', id: 'id-test');

        $result = Label::widget()
            ->inputData($inputData)
            ->forId('MyID')
            ->render();

        $this->assertSame('<label for="MyID">Name</label>', $result);
    }

    public function testDoNotUseInputId(): void
    {
        $result = Label::widget()
            ->content('Name')
            ->useInputId(false)
            ->render();

        $this->assertSame('<label>Name</label>', $result);
    }

    public function testCustomForWithDoNotUseInputId(): void
    {
        $inputData = new PureInputData(label: 'Name', id: 'id-test');

        $result = Label::widget()
            ->inputData($inputData)
            ->useInputId(false)
            ->forId('MyID')
            ->render();

        $this->assertSame('<label for="MyID">Name</label>', $result);
    }

    public function testCustomContent(): void
    {
        $inputData = new PureInputData(label: 'Name', id: 'labelform-name');

        $result = Label::widget()
            ->inputData($inputData)
            ->content('Your name')
            ->render();

        $this->assertSame('<label for="labelform-name">Your name</label>', $result);
    }

    public function testEmptyContent(): void
    {
        $inputData = new PureInputData(label: 'Name', id: 'id-test');

        $result = Label::widget()
            ->inputData($inputData)
            ->content('')
            ->render();

        $this->assertSame('', $result);
    }

    public function testContentAsStringableObject(): void
    {
        $inputData = new PureInputData(label: 'Name');

        $result = Label::widget()
            ->inputData($inputData)
            ->content(new StringableObject('Your name'))
            ->render();

        $this->assertSame('<label>Your name</label>', $result);
    }

    public function testEncode(): void
    {
        $inputData = new PureInputData(label: 'Name');

        $result = Label::widget()
            ->inputData($inputData)
            ->content('Your name >')
            ->render();

        $this->assertSame('<label>Your name &gt;</label>', $result);
    }

    public function testWithoutEncode(): void
    {
        $inputData = new PureInputData(label: 'Name', id: 'labelform-name');

        $result = Label::widget()
            ->inputData($inputData)
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
        $this->assertNotSame($label, $label->id(null));
        $this->assertNotSame($label, $label->class(null));
        $this->assertNotSame($label, $label->addClass(null));
    }
}
