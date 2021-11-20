<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget\Factory;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\File;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class FileTest extends TestCase
{
    use TestTrait;

    public function testAccept(): void
    {
        $this->assertSame(
            '<input type="file" id="typeform-array" name="TypeForm[array][]" accept="image/*">',
            File::widget(['for()' => [$this->formModel, 'array'], 'accept()' => ['image/*']])->render(),
        );
    }

    public function testHiddenAttributes(): void
    {
        $expected = <<<'HTML'
        <input type="hidden" id="test-id" name="TypeForm[array]" value="0"><input type="file" id="typeform-array" name="TypeForm[array][]">
        HTML;
        $this->assertSame(
            $expected,
            File::widget([
                'for()' => [$this->formModel, 'array'],
                'hiddenAttributes()' => [['id' => 'test-id']],
                'uncheckValue()' => ['0'],
            ])->render(),
        );
    }

    public function testMultiple(): void
    {
        $this->assertSame(
            '<input type="file" id="typeform-array" name="TypeForm[array][]" multiple>',
            File::widget(['for()' => [$this->formModel, 'array'], 'multiple()' => []])->render(),
        );
    }

    public function testRender(): void
    {
        $this->assertSame(
            '<input type="file" id="typeform-array" name="TypeForm[array][]">',
            File::widget(['for()' => [$this->formModel, 'array']])->render(),
        );
    }

    public function testUncheckValue(): void
    {
        $expected = <<<'HTML'
        <input type="hidden" name="TypeForm[array]" value="0"><input type="file" id="typeform-array" name="TypeForm[array][]">
        HTML;
        $this->assertSame(
            $expected,
            File::widget(['for()' => [$this->formModel, 'array'], 'uncheckValue()' => ['0']])->render(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer(), []);
        $this->createFormModel(TypeForm::class);
    }
}
