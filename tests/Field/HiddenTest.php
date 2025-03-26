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
            '<input type="hidden" id="hiddenform-key" name="key" value="x100">',
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

    public function testWithExtraConfiguration(): void
    {
        $field = Hidden::widget()
            ->inputContainerTag('div')
            ->useContainer(true)
            ->template('start {input} end')
            ->beforeInput('before')
            ->afterInput('after');

        assertSame(
            '<input type="hidden">',
            $field->render(),
        );
    }
}
