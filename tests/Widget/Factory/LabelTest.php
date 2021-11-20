<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Factory;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Label;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class LabelTest extends TestCase
{
    use TestTrait;

    public function testForId(): void
    {
        $this->assertSame(
            '<label for="test-id">String</label>',
            Label::widget(['for()' => [$this->formModel, 'string'], 'forId()' => ['test-id']])->render(),
        );
    }

    public function testLabel(): void
    {
        $this->assertSame(
            '<label for="typeform-string">Label:</label>',
            Label::widget(['for()' => [$this->formModel, 'string'], 'label()' => ['Label:']])->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<label for="typeform-string">String</label>',
            Label::widget(['for()' => [$this->formModel, 'string']])->render(),
        );
    }

    /**
     * @link https://github.com/yiisoft/form/issues/85
     */
    public function testWithoutEncode(): void
    {
        $this->assertSame(
            '<label for="typeform-string">My&nbsp;Field</label>',
            Label::widget(
                ['for()' => [$this->formModel, 'string'], 'encode()' => [false], 'label()' => ['My&nbsp;Field']]
            )->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
