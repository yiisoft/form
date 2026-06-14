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
            ->addInputAttributes(['data-key' => 'x100'])
            ->inputId('custom-id');

        assertSame(
            '<input type="hidden" data-key="x100" id="custom-id">',
            $field->render(),
        );
    }

    public function testNoLabelRendering(): void
    {
        $this->assertFalse(method_exists(Hidden::widget(), 'label'));
        $this->assertFalse(method_exists(Hidden::widget(), 'hint'));
        $this->assertFalse(method_exists(Hidden::widget(), 'error'));
    }

    public function testNoExtraHtmlConfiguration(): void
    {
        $this->assertFalse(method_exists(Hidden::widget(), 'template'));
        $this->assertFalse(method_exists(Hidden::widget(), 'inputContainer'));
    }
}
