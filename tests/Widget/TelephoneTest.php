<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Widget\Telephone;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class TelephoneTest extends TestCase
{
    private TypeForm $formModel;

    public function testImmutability(): void
    {
        $telephone = Telephone::widget();
        $this->assertNotSame($telephone, $telephone->maxlength(0));
        $this->assertNotSame($telephone, $telephone->minlength(0));
        $this->assertNotSame($telephone, $telephone->pattern(''));
        $this->assertNotSame($telephone, $telephone->placeholder(''));
        $this->assertNotSame($telephone, $telephone->size(0));
    }

    public function testMaxLength(): void
    {
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]" maxlength="10">',
            Telephone::widget()->config($this->formModel, 'string')->maxlength(10)->render(),
        );
    }

    public function testMinLength(): void
    {
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]" minlength="4">',
            Telephone::widget()->config($this->formModel, 'string')->minlength(4)->render(),
        );
    }

    public function testPattern(): void
    {
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]" pattern="[789][0-9]{9}">',
            Telephone::widget()->config($this->formModel, 'string')->pattern('[789][0-9]{9}')->render(),
        );
    }

    public function testPlaceholder(): void
    {
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]" placeholder="PlaceHolder Text">',
            Telephone::widget()->config($this->formModel, 'string')->placeholder('PlaceHolder Text')->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]">',
            Telephone::widget()->config($this->formModel, 'string')->render(),
        );
    }

    public function testSize(): void
    {
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]" size="20">',
            Telephone::widget()->config($this->formModel, 'string')->size(20)->render(),
        );
    }

    public function testValue(): void
    {
        // value null
        $this->assertSame(
            '<input type="tel" id="typeform-tonull" name="TypeForm[toNull]">',
            Telephone::widget()->config($this->formModel, 'toNull')->render(),
        );

        // value telephone string '+71234567890'
        $this->formModel->setAttribute('string', '+71234567890');
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]" value="+71234567890">',
            Telephone::widget()->config($this->formModel, 'string')->render(),
        );

        // value telephone numeric string '71234567890'
        $this->formModel->setAttribute('string', '71234567890');
        $this->assertSame(
            '<input type="tel" id="typeform-string" name="TypeForm[string]" value="71234567890">',
            Telephone::widget()->config($this->formModel, 'string')->render(),
        );

        // value telephone integer 71234567890
        $this->formModel->setAttribute('int', 71234567890);
        $this->assertSame(
            '<input type="tel" id="typeform-int" name="TypeForm[int]" value="71234567890">',
            Telephone::widget()->config($this->formModel, 'int')->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Telephone widget must be a string, numeric o null value.');
        Telephone::widget()->config($this->formModel, 'array')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->formModel = new TypeForm();
    }
}
