<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\Hidden;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class HiddenTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $inputData = new PureInputData('key', 'x100', id: 'hiddenform-key');

        $field = Hidden::widget()->inputData($inputData);

        $this->assertSame(
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
}
