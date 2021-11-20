<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Factory;

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

    public function testContent(): void
    {
        $this->assertSame(
            '<div>Write your text.</div>',
            Hint::widget(['for()' => [$this->formModel, 'string'], 'hint()' => ['Write your text.']])->render(),
        );
    }

    public function testEncodeFalse(): void
    {
        $this->assertSame(
            '<div>Write&nbsp;your&nbsp;text.</div>',
            Hint::widget([
                'for()' => [$this->formModel, 'string'],
                'hint()' => ['Write&nbsp;your&nbsp;text.'],
                'encode()' => [false],
            ])->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<div>Write your text string.</div>',
            Hint::widget(['for()' => [$this->formModel, 'string']])->render(),
        );
    }

    public function testTag(): void
    {
        $this->assertSame(
            '<span>Write your text string.</span>',
            Hint::widget(['for()' => [$this->formModel, 'string'], 'tag()' => ['span']])->render(),
        );
    }

    public function testTagException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag name cannot be empty.');
        Hint::widget(['for()' => [$this->formModel, 'string'], 'tag()' => ['']])->render();
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
