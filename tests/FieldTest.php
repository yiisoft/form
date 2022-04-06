<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field;
use Yiisoft\Form\Tests\Support\AssertTrait;
use Yiisoft\Form\Tests\Support\Form\CheckboxForm;
use Yiisoft\Form\Tests\Support\Form\DateForm;
use Yiisoft\Form\Tests\Support\Form\HiddenForm;
use Yiisoft\Form\Tests\Support\Form\TextForm;

final class FieldTest extends TestCase
{
    use AssertTrait;

    public function testCheckbox(): void
    {
        $result = Field::checkbox(new CheckboxForm(), 'blue')->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <input type="hidden" name="CheckboxForm[blue]" value="0"><label><input type="checkbox" id="checkboxform-blue" name="CheckboxForm[blue]" value="1"> Blue color</label>
            </div>
            HTML,
            $result
        );
    }

    public function testDate(): void
    {
        $result = Field::date(new DateForm(), 'birthday')->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <label for="dateform-birthday">Your birthday</label>
            <input type="date" id="dateform-birthday" name="DateForm[birthday]" value="1996-12-19">
            <div>Birthday date.</div>
            </div>
            HTML,
            $result
        );
    }

    public function testHidden(): void
    {
        $result = Field::hidden(new HiddenForm(), 'key')->render();
        $this->assertSame(
            '<input type="hidden" id="hiddenform-key" name="HiddenForm[key]" value="x100">',
            $result
        );
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

    public function testLabel(): void
    {
        $result = Field::label(new TextForm(), 'job')->render();
        $this->assertSame('<label for="textform-job">Job</label>', $result);
    }

    public function testHint(): void
    {
        $result = Field::hint(TextForm::validated(), 'name')->render();
        $this->assertSame('<div>Input your full name.</div>', $result);
    }

    public function testError(): void
    {
        $result = Field::error(TextForm::validated(), 'name')->render();
        $this->assertSame('<div>Value cannot be blank.</div>', $result);
    }
}
