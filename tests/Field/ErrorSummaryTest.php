<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\ErrorSummary;
use Yiisoft\Form\Tests\Support\Form\ErrorSummaryForm;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class ErrorSummaryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testBase(): void
    {
        $result = ErrorSummary::widget()
            ->formModel(ErrorSummaryForm::validated())
            ->render();

        $expected = <<<HTML
            <div>
            <p>Please fix the following errors:</p>
            <ul>
            <li>Value cannot be blank.</li>
            <li>&lt;b&gt;Very&lt;/b&gt; old.</li>
            <li>Bad year.</li>
            </ul>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testNonValidateForm(): void
    {
        $result = ErrorSummary::widget()
            ->formModel(new ErrorSummaryForm())
            ->render();

        $this->assertSame('', $result);
    }

    public function testNoEncode(): void
    {
        $result = ErrorSummary::widget()
            ->formModel(ErrorSummaryForm::validated())
            ->onlyAttributes('age')
            ->encode(false)
            ->render();

        $expected = <<<HTML
            <div>
            <p>Please fix the following errors:</p>
            <ul>
            <li><b>Very</b> old.</li>
            </ul>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testShowAllErrors(): void
    {
        $result = ErrorSummary::widget()
            ->formModel(ErrorSummaryForm::validated())
            ->onlyAttributes('year')
            ->showAllErrors()
            ->render();

        $expected = <<<HTML
            <div>
            <p>Please fix the following errors:</p>
            <ul>
            <li>Bad year.</li>
            <li>Very Bad year.</li>
            </ul>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testFooter(): void
    {
        $result = ErrorSummary::widget()
            ->formModel(ErrorSummaryForm::validated())
            ->onlyAttributes('year')
            ->footer('Footer text.')
            ->footerAttributes(['class' => 'footer'])
            ->render();

        $expected = <<<HTML
            <div>
            <p>Please fix the following errors:</p>
            <ul>
            <li>Bad year.</li>
            </ul>
            <p class="footer">Footer text.</p>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testHeader(): void
    {
        $result = ErrorSummary::widget()
            ->formModel(ErrorSummaryForm::validated())
            ->onlyAttributes('year')
            ->header('Header text.')
            ->headerAttributes(['class' => 'header'])
            ->render();

        $expected = <<<HTML
            <div>
            <p class="header">Header text.</p>
            <ul>
            <li>Bad year.</li>
            </ul>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testWithoutForm(): void
    {
        $field =  ErrorSummary::widget();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Form model is not set.');
        $field->render();
    }

    public function testImmutability(): void
    {
        $field = ErrorSummary::widget();

        $this->assertNotSame($field, $field->formModel(new ErrorSummaryForm()));
        $this->assertNotSame($field, $field->encode(false));
        $this->assertNotSame($field, $field->showAllErrors());
        $this->assertNotSame($field, $field->onlyAttributes());
        $this->assertNotSame($field, $field->header(''));
        $this->assertNotSame($field, $field->headerAttributes([]));
        $this->assertNotSame($field, $field->footer(''));
        $this->assertNotSame($field, $field->footerAttributes([]));
    }
}
