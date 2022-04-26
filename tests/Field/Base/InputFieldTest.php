<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Base;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\Support\Form\TextForm;
use Yiisoft\Form\Tests\Support\StubInputField;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class InputFieldTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testWithoutFormModel(): void
    {
        $widget = StubInputField::widget();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Form model is not set.');
        $widget->render();
    }

    public function testForm(): void
    {
        $result = StubInputField::widget()
            ->attribute(new TextForm(), 'company')
            ->form('CreatePost')
            ->render();

        $expected = <<<HTML
            <div>
            <label for="textform-company">Company</label>
            <input type="text" id="textform-company" name="TextForm[company]" value form="CreatePost">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = StubInputField::widget();

        $this->assertNotSame($field, $field->form(null));
        $this->assertNotSame($field, $field->inputId(null));
        $this->assertNotSame($field, $field->setInputIdAttribute(true));
        $this->assertNotSame($field, $field->inputTagAttributes([]));
    }
}
