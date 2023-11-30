<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Part;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\YiisoftFormModel\FormModelInputData;
use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\Base\InputData\InputDataInterface;
use Yiisoft\Form\Field\Part\Error;
use Yiisoft\Form\Tests\Support\Form\ErrorForm;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Validator\Validator;
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
        $result = Error::widget()
            ->inputData(new FormModelInputData($this->createValidatedErrorForm(), 'name'))
            ->render();

        $this->assertSame('<div>Value cannot be blank.</div>', $result);
    }

    public function testAttributeWithoutError(): void
    {
        $result = Error::widget()
            ->inputData(new FormModelInputData($this->createValidatedErrorForm(), 'age'))
            ->render();

        $this->assertSame('', $result);
    }

    public function testCustomTag(): void
    {
        $result = Error::widget()
            ->inputData(new FormModelInputData($this->createValidatedErrorForm(), 'name'))
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
        $result = Error::widget()
            ->inputData(new FormModelInputData($this->createValidatedErrorForm(), 'name'))
            ->addAttributes(['class' => 'red'])
            ->addAttributes(['data-number' => 18])
            ->render();

        $this->assertSame('<div class="red" data-number="18">Value cannot be blank.</div>', $result);
    }

    public function testAttributes(): void
    {
        $result = Error::widget()
            ->inputData(new FormModelInputData($this->createValidatedErrorForm(), 'name'))
            ->attributes(['class' => 'red'])
            ->attributes(['data-number' => 18])
            ->render();

        $this->assertSame('<div data-number="18">Value cannot be blank.</div>', $result);
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
        $result = Error::widget()
            ->inputData(new FormModelInputData($this->createValidatedErrorForm(), 'name'))
            ->id($id)
            ->render();

        $expected = '<div' . $expectedId . '>Value cannot be blank.</div>';

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
        $result = Error::widget()
            ->inputData(new FormModelInputData($this->createValidatedErrorForm(), 'name'))
            ->addClass('main')
            ->addClass(...$class)
            ->render();

        $expected = '<div' . $expectedClassAttribute . '>Value cannot be blank.</div>';

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
        $result = Error::widget()
            ->inputData(new FormModelInputData($this->createValidatedErrorForm(), 'name'))
            ->addClass($class)
            ->render();

        $expected = '<div' . $expectedClassAttribute . '>Value cannot be blank.</div>';

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
        $result = Error::widget()
            ->inputData(new FormModelInputData($this->createValidatedErrorForm(), 'name'))
            ->class('red')
            ->class(...$class)
            ->render();

        $expected = '<div' . $expectedClassAttribute . '>Value cannot be blank.</div>';

        $this->assertSame($expected, $result);
    }

    public function testEncode(): void
    {
        $result = Error::widget()
            ->inputData(new FormModelInputData($this->createValidatedErrorForm(), 'name'))
            ->message('your name >')
            ->render();

        $this->assertSame('<div>your name &gt;</div>', $result);
    }

    public function testWithoutEncode(): void
    {
        $result = Error::widget()
            ->inputData(new FormModelInputData($this->createValidatedErrorForm(), 'name'))
            ->message('<b>your name</b>')
            ->encode(false)
            ->render();

        $this->assertSame('<div><b>your name</b></div>', $result);
    }

    public function testCustomMessage(): void
    {
        $result = Error::widget()
            ->inputData(new FormModelInputData($this->createValidatedErrorForm(), 'name'))
            ->message('Invalid name.')
            ->render();

        $this->assertSame('<div>Invalid name.</div>', $result);
    }

    public function testCustomMessageWithoutError(): void
    {
        $result = Error::widget()
            ->inputData(new FormModelInputData($this->createValidatedErrorForm(), 'age'))
            ->message('Invalid name.')
            ->render();

        $this->assertSame('<div>Invalid name.</div>', $result);
    }

    public function testMessageCallback(): void
    {
        $result = Error::widget()
            ->inputData(new FormModelInputData($this->createValidatedErrorForm(), 'name'))
            ->messageCallback(
                static fn (string $message, ?InputDataInterface $inputData): string => 'Attribute "' . $inputData->getLabel() . '" error: ' . $message
            )
            ->render();

        $this->assertSame('<div>Attribute "Name" error: Value cannot be blank.</div>', $result);
    }

    public function testMessageCallbackWithCustomMessage(): void
    {
        $result = Error::widget()
            ->inputData(new FormModelInputData($this->createValidatedErrorForm(), 'name'))
            ->message('Invalid value.')
            ->messageCallback(
                static fn (string $message, ?InputDataInterface $inputData): string => 'Attribute "' . $inputData->getLabel() . '" error: ' . $message
            )
            ->render();

        $this->assertSame('<div>Attribute "Name" error: Invalid value.</div>', $result);
    }

    public function testMessageCallbackWithMessageAndWithoutError(): void
    {
        $result = Error::widget()
            ->inputData(new FormModelInputData($this->createValidatedErrorForm(), 'age'))
            ->message('Invalid value.')
            ->messageCallback(
                static fn (string $message, ?InputDataInterface $inputData): string => 'Attribute "' . $inputData->getLabel() . '" error: ' . $message
            )
            ->render();

        $this->assertSame('<div>Attribute "Age" error: Invalid value.</div>', $result);
    }

    private function createValidatedErrorForm(): ErrorForm
    {
        $form = new ErrorForm();
        (new Validator())->validate($form);
        return $form;
    }
}
