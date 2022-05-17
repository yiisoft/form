<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field\Part;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Part\Label;
use Yiisoft\Form\Tests\Support\Form\LabelForm;
use Yiisoft\Form\Tests\Support\StringableObject;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class LabelTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testBase(): void
    {
        $result = Label::widget()
            ->formAttribute(new LabelForm(), 'name')
            ->render();

        $this->assertSame('<label for="labelform-name">Name</label>', $result);
    }

    public function testAttributes(): void
    {
        $result = Label::widget()
            ->formAttribute(new LabelForm(), 'name')
            ->attributes(['class' => 'red', 'id' => 'RedLabel'])
            ->render();

        $this->assertSame('<label id="RedLabel" class="red" for="labelform-name">Name</label>', $result);
    }

    public function testDoNotSetFor(): void
    {
        $result = Label::widget()
            ->formAttribute(new LabelForm(), 'name')
            ->setFor(false)
            ->render();

        $this->assertSame('<label>Name</label>', $result);
    }

    public function customFor(): void
    {
        $result = Label::widget()
            ->formAttribute(new LabelForm(), 'name')
            ->forId('MyID')
            ->render();

        $this->assertSame('<label for="MyID">Name</label>', $result);
    }

    public function testDoNotUseInputId(): void
    {
        $result = Label::widget()
            ->formAttribute(new LabelForm(), 'name')
            ->useInputId(false)
            ->render();

        $this->assertSame('<label>Name</label>', $result);
    }

    public function testCustomForWithDoNotUseInputId(): void
    {
        $result = Label::widget()
            ->formAttribute(new LabelForm(), 'name')
            ->useInputId(false)
            ->forId('MyID')
            ->render();

        $this->assertSame('<label for="MyID">Name</label>', $result);
    }

    public function testCustomContent(): void
    {
        $result = Label::widget()
            ->formAttribute(new LabelForm(), 'name')
            ->content('Your name')
            ->render();

        $this->assertSame('<label for="labelform-name">Your name</label>', $result);
    }

    public function testEmptyContent(): void
    {
        $result = Label::widget()
            ->formAttribute(new LabelForm(), 'name')
            ->content('')
            ->render();

        $this->assertSame('', $result);
    }

    public function testContentAsStringableObject(): void
    {
        $result = Label::widget()
            ->formAttribute(new LabelForm(), 'name')
            ->content(new StringableObject('Your name'))
            ->render();

        $this->assertSame('<label for="labelform-name">Your name</label>', $result);
    }

    public function testEncode(): void
    {
        $result = Label::widget()
            ->formAttribute(new LabelForm(), 'name')
            ->content('Your name >')
            ->render();

        $this->assertSame('<label for="labelform-name">Your name &gt;</label>', $result);
    }

    public function testWithoutEncode(): void
    {
        $result = Label::widget()
            ->formAttribute(new LabelForm(), 'name')
            ->content('<b>Name</b>')
            ->encode(false)
            ->render();

        $this->assertSame('<label for="labelform-name"><b>Name</b></label>', $result);
    }

    public function testImmutability(): void
    {
        $label = Label::widget();

        $this->assertNotSame($label, $label->attributes([]));
        $this->assertNotSame($label, $label->setFor(true));
        $this->assertNotSame($label, $label->forId(null));
        $this->assertNotSame($label, $label->useInputId(true));
        $this->assertNotSame($label, $label->content(null));
        $this->assertNotSame($label, $label->encode(true));
    }
}
