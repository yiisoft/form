<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Widget\File;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FileTest extends TestCase
{
    private TypeForm $formModel;

    public function testAccept(): void
    {
        $this->assertSame(
            '<input type="file" id="typeform-array" name="TypeForm[array][]" accept="image/*">',
            File::widget()->config($this->formModel, 'array')->accept('image/*')->render(),
        );
    }

    public function testHiddenAttributes(): void
    {
        $expected = <<<'HTML'
        <input type="hidden" id="test-id" name="TypeForm[array]" value="0"><input type="file" id="typeform-array" name="TypeForm[array][]">
        HTML;
        $html = File::widget()
            ->config($this->formModel, 'array')
            ->hiddenAttributes(['id' => 'test-id'])
            ->uncheckValue('0')
            ->render();
        $this->assertSame($expected, $html);
    }

    public function testImmutability(): void
    {
        $fileInput = File::widget();
        $this->assertNotSame($fileInput, $fileInput->accept(''));
        $this->assertNotSame($fileInput, $fileInput->hiddenAttributes([]));
        $this->assertNotSame($fileInput, $fileInput->multiple());
        $this->assertNotSame($fileInput, $fileInput->uncheckValue(null));
    }

    public function testMultiple(): void
    {
        $this->assertSame(
            '<input type="file" id="typeform-array" name="TypeForm[array][]" multiple>',
            File::widget()->config($this->formModel, 'array')->multiple()->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="file" id="typeform-array" name="TypeForm[array][]">',
            File::widget()->config($this->formModel, 'array')->render(),
        );
    }

    public function testUncheckValue(): void
    {
        $expected = <<<'HTML'
        <input type="hidden" name="TypeForm[array]" value="0"><input type="file" id="typeform-array" name="TypeForm[array][]">
        HTML;
        $html = File::widget()->config($this->formModel, 'array')->uncheckValue('0')->render();
        $this->assertSame($expected, $html);
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->formModel = new TypeForm();
    }
}
