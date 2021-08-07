<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Widget\AttributeWidget;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class AttributeWidgetTest extends TestCase
{
    public function testAutofocus(): void
    {
        $this->assertSame('<test autofocus>', AttributeWidget::widget()->autofocus()->render());
    }

    public function testDisabled(): void
    {
        $this->assertSame('<test disabled>', AttributeWidget::widget()->disabled()->render());
    }
    public function testMin(): void
    {
        $this->assertSame(
            '<test min="2020-05-01">',
            AttributeWidget::widget()->min('2020-05-01')->render(),
        );
    }

    public function testMax(): void
    {
        $this->assertSame(
            '<test max="2021-12-31">',
            AttributeWidget::widget()->max('2021-12-31')->render(),
        );
    }

    public function testReadOnly(): void
    {
        $this->assertSame('<test readonly>', AttributeWidget::widget()->readOnly()->render());
    }

    public function testRequired(): void
    {
        $this->assertSame('<test required>', AttributeWidget::widget()->required()->render());
    }

    public function testTabIndex(): void
    {
        $this->assertSame('<test tabindex="5">', AttributeWidget::widget()->tabIndex(5)->render());
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
    }
}
