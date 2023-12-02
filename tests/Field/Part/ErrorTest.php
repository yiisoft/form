<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Part;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\Base\InputData\InputDataInterface;
use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class ErrorTest extends TestCase
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
            validationErrors: ['Value cannot be blank.'],
        );

        $result = Error::widget()->inputData($inputData)->render();

        $this->assertSame('<div>Value cannot be blank.</div>', $result);
    }

    public function testWithoutError(): void
    {
        $inputData = new PureInputData();

        $result = Error::widget()->inputData($inputData)->render();

        $this->assertSame('', $result);
    }

    public function testCustomTag(): void
    {
        $inputData = new PureInputData(
            validationErrors: ['Value cannot be blank.'],
        );

        $result = Error::widget()
            ->inputData($inputData)
            ->tag('b')
            ->render();

        $this->assertSame('<b>Value cannot be blank.</b>', $result);
    }

    public function testEmptyTag(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name cannot be empty.');
        Error::widget()
            ->inputData(new PureInputData())
            ->tag('');
    }

    public function testAddAttributes(): void
    {
        $inputData = new PureInputData(
            validationErrors: ['Value cannot be blank.'],
        );

        $result = Error::widget()
            ->inputData($inputData)
            ->addAttributes(['class' => 'red'])
            ->addAttributes(['data-number' => 18])
            ->render();

        $this->assertSame('<div class="red" data-number="18">Value cannot be blank.</div>', $result);
    }

    public function testAttributes(): void
    {
        $inputData = new PureInputData(
            validationErrors: ['Value cannot be blank.'],
        );

        $result = Error::widget()
            ->inputData($inputData)
            ->attributes(['class' => 'red'])
            ->attributes(['data-number' => 18])
            ->render();

        $this->assertSame('<div data-number="18">Value cannot be blank.</div>', $result);
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
        $inputData = new PureInputData(
            validationErrors: ['Value cannot be blank.'],
        );

        $result = Error::widget()
            ->inputData($inputData)
            ->id($id)
            ->render();

        $expected = '<div' . $expectedId . '>Value cannot be blank.</div>';

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
        $inputData = new PureInputData(
            validationErrors: ['Value cannot be blank.'],
        );

        $result = Error::widget()
            ->inputData($inputData)
            ->addClass('main')
            ->addClass(...$class)
            ->render();

        $expected = '<div' . $expectedClassAttribute . '>Value cannot be blank.</div>';

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
        $inputData = new PureInputData(
            validationErrors: ['Value cannot be blank.'],
        );

        $result = Error::widget()
            ->inputData($inputData)
            ->addClass($class)
            ->render();

        $expected = '<div' . $expectedClassAttribute . '>Value cannot be blank.</div>';

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
        $inputData = new PureInputData(
            validationErrors: ['Value cannot be blank.'],
        );

        $result = Error::widget()
            ->inputData($inputData)
            ->class('red')
            ->class(...$class)
            ->render();

        $expected = '<div' . $expectedClassAttribute . '>Value cannot be blank.</div>';

        $this->assertSame($expected, $result);
    }

    public function testEncode(): void
    {
        $inputData = new PureInputData(
            validationErrors: ['Value cannot be blank.'],
        );

        $result = Error::widget()
            ->inputData($inputData)
            ->message('your name >')
            ->render();

        $this->assertSame('<div>your name &gt;</div>', $result);
    }

    public function testWithoutEncode(): void
    {
        $inputData = new PureInputData(
            validationErrors: ['Value cannot be blank.'],
        );

        $result = Error::widget()
            ->inputData($inputData)
            ->message('<b>your name</b>')
            ->encode(false)
            ->render();

        $this->assertSame('<div><b>your name</b></div>', $result);
    }

    public function testCustomMessage(): void
    {
        $inputData = new PureInputData(
            validationErrors: ['Value cannot be blank.'],
        );

        $result = Error::widget()
            ->inputData($inputData)
            ->message('Invalid name.')
            ->render();

        $this->assertSame('<div>Invalid name.</div>', $result);
    }

    public function testCustomMessageWithoutError(): void
    {
        $inputData = new PureInputData(
            label: 'Age',
            validationErrors: [],
        );

        $result = Error::widget()
            ->inputData($inputData)
            ->message('Invalid name.')
            ->render();

        $this->assertSame('<div>Invalid name.</div>', $result);
    }

    public function testMessageCallback(): void
    {
        $inputData = new PureInputData(
            label: 'Name',
            validationErrors: ['Value cannot be blank.'],
        );

        $result = Error::widget()
            ->inputData($inputData)
            ->messageCallback(
                static fn (string $message, ?InputDataInterface $inputData): string => 'Attribute "' . $inputData->getLabel() . '" error: ' . $message
            )
            ->render();

        $this->assertSame('<div>Attribute "Name" error: Value cannot be blank.</div>', $result);
    }

    public function testMessageCallbackWithCustomMessage(): void
    {
        $inputData = new PureInputData(
            label: 'Name',
            validationErrors: ['Value cannot be blank.'],
        );

        $result = Error::widget()
            ->inputData($inputData)
            ->message('Invalid value.')
            ->messageCallback(
                static fn (string $message, ?InputDataInterface $inputData): string => 'Attribute "' . $inputData->getLabel() . '" error: ' . $message
            )
            ->render();

        $this->assertSame('<div>Attribute "Name" error: Invalid value.</div>', $result);
    }

    public function testMessageCallbackWithMessageAndWithoutError(): void
    {
        $inputData = new PureInputData(
            label: 'Age',
            validationErrors: [],
        );

        $result = Error::widget()
            ->inputData($inputData)
            ->message('Invalid value.')
            ->messageCallback(
                static fn (string $message, ?InputDataInterface $inputData): string => 'Attribute "' . $inputData->getLabel() . '" error: ' . $message
            )
            ->render();

        $this->assertSame('<div>Attribute "Age" error: Invalid value.</div>', $result);
    }
}
