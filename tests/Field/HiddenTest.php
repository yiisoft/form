<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Hidden;
use Yiisoft\Form\PureField\InputData;
use Yiisoft\Form\Theme\ThemeContainer;

use function PHPUnit\Framework\assertSame;

final class HiddenTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $inputData = new InputData('key', 'x100', id: 'hiddenform-key');

        $field = Hidden::widget()->inputData($inputData);

        assertSame(
            '<input type="hidden" name="key" value="x100" id="hiddenform-key">',
            $field->render(),
        );
    }

    public function testInvalidValue(): void
    {
        $field = Hidden::widget()->value(true);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Hidden widget requires a string, numeric or null value.');
        $field->render();
    }

    public function testWithInputAttributes(): void
    {
        $field = Hidden::widget()
            ->addInputAttributes(['data-id' => '42'])
            ->addInputAttributes(['data-key' => 'x100'])
            ->inputId('custom-id');

        assertSame(
            '<input type="hidden" data-id="42" data-key="x100" id="custom-id">',
            $field->render(),
        );
    }

    public function testImmutability(): void
    {
        $widget = Hidden::widget();

        $this->assertNotSame($widget, $widget->inputId('id1'));
        $this->assertNotSame($widget, $widget->shouldSetInputId(false));
        $this->assertNotSame($widget, $widget->inputAttributes(['a' => '1']));
        $this->assertNotSame($widget, $widget->addInputAttributes(['a' => '1']));
        $this->assertNotSame($widget, $widget->inputClass('red'));
        $this->assertNotSame($widget, $widget->addInputClass('red'));
        $this->assertNotSame($widget, $widget->form('my-form'));
    }

    public function testShouldSetInputIdFalse(): void
    {
        $field = Hidden::widget()
            ->inputData(new InputData('key', 'x100', id: 'hiddenform-key'))
            ->shouldSetInputId(false);

        assertSame(
            '<input type="hidden" name="key" value="x100">',
            $field->render(),
        );
    }

    public function testInputAttributesReplace(): void
    {
        $field = Hidden::widget()
            ->inputAttributes(['data-a' => '1', 'data-b' => '2']);

        assertSame(
            '<input type="hidden" data-a="1" data-b="2">',
            $field->render(),
        );
    }

    public function testInputClass(): void
    {
        $field = Hidden::widget()->inputClass('red', 'bold');

        assertSame(
            '<input type="hidden" class="red bold">',
            $field->render(),
        );
    }

    public function testAddInputClass(): void
    {
        $field = Hidden::widget()
            ->addInputClass('red')
            ->addInputClass('bold');

        assertSame(
            '<input type="hidden" class="red bold">',
            $field->render(),
        );
    }

    public function testForm(): void
    {
        $field = Hidden::widget()->form('my-form');

        assertSame(
            '<input type="hidden" form="my-form">',
            $field->render(),
        );
    }
}
