<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field;
use Yiisoft\Form\FieldStaticFactory;
use Yiisoft\Form\Tests\Support\AssertTrait;
use Yiisoft\Form\Tests\Support\Form\TextForm;

final class FieldTest extends TestCase
{
    use AssertTrait;

    protected function setUp(): void
    {
        FieldStaticFactory::initialize();
        parent::setUp();
    }

    public function testText(): void
    {
        $result = Field::text(new TextForm(), 'job')->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <label for="textform-job">Job</label>
            <input type="text" id="textform-job" name="TextForm[job]" value>
            </div>
            HTML,
            $result
        );
    }

    public function testTextWithConfig(): void
    {
        $config = [
            'containerTag()' => ['section'],
            'containerTagAttributes()' => [['class' => 'wrapper']],
        ];
        $result = Field::text(new TextForm(), 'job', $config)->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <section class="wrapper">
            <label for="textform-job">Job</label>
            <input type="text" id="textform-job" name="TextForm[job]" value>
            </section>
            HTML,
            $result
        );
    }

    public function testLabel(): void
    {
        $result = Field::label(new TextForm(), 'job')->render();
        $this->assertSame('<label for="textform-job">Job</label>', $result);
    }

    public function testLabelWithConfig(): void
    {
        $config = [
            'forId()' => ['MyID'],
        ];

        $result = Field::label(new TextForm(), 'job', $config)->render();

        $this->assertSame('<label for="MyID">Job</label>', $result);
    }

    public function testHint(): void
    {
        $result = Field::hint(TextForm::validated(), 'name')->render();
        $this->assertSame('<div>Input your full name.</div>', $result);
    }

    public function testHintWithConfig(): void
    {
        $config = [
            'tag()' => ['b'],
        ];

        $result = Field::hint(TextForm::validated(), 'name', $config)->render();

        $this->assertSame('<b>Input your full name.</b>', $result);
    }

    public function testError(): void
    {
        $result = Field::error(TextForm::validated(), 'name')->render();
        $this->assertSame('<div>Value cannot be blank.</div>', $result);
    }

    public function testErrorWithConfig(): void
    {
        $config = [
            'tag()' => ['b'],
        ];

        $result = Field::error(TextForm::validated(), 'name', $config)->render();

        $this->assertSame('<b>Value cannot be blank.</b>', $result);
    }
}
