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
            ->attribute(new LabelForm(), 'name')
            ->render();

        $this->assertSame('<label for="labelform-name">Name</label>', $result);
    }

    public function testDoNotSetForAttribute(): void
    {
        $result = Label::widget()
            ->attribute(new LabelForm(), 'name')
            ->setForAttribute(false)
            ->render();

        $this->assertSame('<label>Name</label>', $result);
    }

    public function customFor(): void
    {
        $result = Label::widget()
            ->attribute(new LabelForm(), 'name')
            ->forId('MyID')
            ->render();

        $this->assertSame('<label for="MyID">Name</label>', $result);
    }

    public function testDoNotUseInputIdAttribute(): void
    {
        $result = Label::widget()
            ->attribute(new LabelForm(), 'name')
            ->useInputIdAttribute(false)
            ->render();

        $this->assertSame('<label>Name</label>', $result);
    }

    public function testCustomForWithDoNotUseInputIdAttribute(): void
    {
        $result = Label::widget()
            ->attribute(new LabelForm(), 'name')
            ->useInputIdAttribute(false)
            ->forId('MyID')
            ->render();

        $this->assertSame('<label for="MyID">Name</label>', $result);
    }

    public function testCustomContent(): void
    {
        $result = Label::widget()
            ->attribute(new LabelForm(), 'name')
            ->content('Your name')
            ->render();

        $this->assertSame('<label for="labelform-name">Your name</label>', $result);
    }

    public function testEmptyContent(): void
    {
        $result = Label::widget()
            ->attribute(new LabelForm(), 'name')
            ->content('')
            ->render();

        $this->assertSame('<label for="labelform-name"></label>', $result);
    }

    public function testContentAsStringableObject(): void
    {
        $result = Label::widget()
            ->attribute(new LabelForm(), 'name')
            ->content(new StringableObject('Your name'))
            ->render();

        $this->assertSame('<label for="labelform-name">Your name</label>', $result);
    }

    public function testEncode(): void
    {
        $result = Label::widget()
            ->attribute(new LabelForm(), 'name')
            ->content('Your name >')
            ->render();

        $this->assertSame('<label for="labelform-name">Your name &gt;</label>', $result);
    }

    public function testWithoutEncode(): void
    {
        $result = Label::widget()
            ->attribute(new LabelForm(), 'name')
            ->content('<b>Name</b>')
            ->encode(false)
            ->render();

        $this->assertSame('<label for="labelform-name"><b>Name</b></label>', $result);
    }
}
