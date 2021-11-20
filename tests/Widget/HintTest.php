<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Hint;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class HintTest extends TestCase
{
    use TestTrait;

    public function testEncodeWithFalse(): void
    {
        $html = Hint::widget()
            ->for($this->formModel, 'string')
            ->encode(false)
            ->hint('Write&nbsp;your&nbsp;text.')
            ->render();
        $this->assertSame('<div>Write&nbsp;your&nbsp;text.</div>', $html);
    }

    public function testHint(): void
    {
        $this->assertSame(
            '<div>Write your text.</div>',
            Hint::widget()->for($this->formModel, 'string')->hint('Write your text.')->render(),
        );
    }

    public function testImmutability(): void
    {
        $hint = Hint::widget();
        $this->assertNotSame($hint, $hint->encode(false));
        $this->assertNotSame($hint, $hint->hint(null));
        $this->assertNotSame($hint, $hint->tag(''));
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<div>Write your text string.</div>',
            Hint::widget()->for($this->formModel, 'string')->render(),
        );
    }

    public function testTag(): void
    {
        $this->assertSame(
            '<span>Write your text string.</span>',
            Hint::widget()->for($this->formModel, 'string')->tag('span')->render(),
        );
    }

    public function testTagException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name cannot be empty.');
        Hint::widget()->for($this->formModel, 'string')->tag('')->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
