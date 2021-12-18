<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field;
use Yiisoft\Form\FieldStaticFactory;
use Yiisoft\Form\Tests\Support\AssertTrait;
use Yiisoft\Form\Tests\Support\Form\InputTextForm;

final class FieldTest extends TestCase
{
    use AssertTrait;

    protected function setUp(): void
    {
        FieldStaticFactory::initialize();
        parent::setUp();
    }

    public function testInputText(): void
    {
        $result = Field::inputText(new InputTextForm(), 'job')->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <label for="inputtextform-job">Job</label>
            <input type="text" id="inputtextform-job" name="InputTextForm[job]" value>
            </div>
            HTML,
            $result
        );
    }

    public function testLabel(): void
    {
        $result = Field::label(new InputTextForm(), 'job')->render();
        $this->assertSame('<label for="inputtextform-job">Job</label>', $result);
    }

    public function testHint(): void
    {
        $result = Field::hint(InputTextForm::validated(), 'name')->render();
        $this->assertSame('<div>Input your full name.</div>', $result);
    }

    public function testError(): void
    {
        $result = Field::error(InputTextForm::validated(), 'name')->render();
        $this->assertSame('<div>Value cannot be blank.</div>', $result);
    }
}
