<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Widget\Hidden;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class HiddenTest extends TestCase
{
    private TypeForm $formModel;

    public function testDisabled(): void
    {
        $this->assertEquals(
            '<input type="hidden" name="typeform-string" value="" disabled>',
            Hidden::widget()->config($this->formModel, 'string')->disabled()->render(),
        );
    }

    public function testForm(): void
    {
        $this->assertEquals(
            '<input type="hidden" name="typeform-string" value="" form="form-id">',
            Hidden::widget()->config($this->formModel, 'string')->form('form-id')->render(),
        );
    }

    public function testImmutability(): void
    {
        $hiddenInput = Hidden::widget();
        $this->assertNotSame($hiddenInput, $hiddenInput->disabled());
        $this->assertNotSame($hiddenInput, $hiddenInput->form(''));
    }

    public function testRender(): void
    {
        $this->assertEquals(
            '<input type="hidden" name="typeform-string" value="">',
            Hidden::widget()->config($this->formModel, 'string')->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Hidden widget requires a string value.');
        $html = Hidden::widget()->config($this->formModel, 'array')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->formModel = new TypeForm();
    }
}
