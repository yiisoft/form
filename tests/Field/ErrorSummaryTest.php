<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\ErrorSummary;
use Yiisoft\Form\Tests\Support\AssertTrait;
use Yiisoft\Form\Tests\Support\Form\ErrorSummaryForm;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class ErrorSummaryTest extends TestCase
{
    use AssertTrait;

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

        $expected = <<<'HTML'
        <div>
        <p>Please fix the following errors:</p>
        <ul>
        <li>Value cannot be blank.</li>
        </ul>
        </div>
        HTML;

        $this->assertStringEqualsStringIgnoringLineEndings($expected, $result);
    }

    public function testNonValidateForm(): void
    {
        $result = ErrorSummary::widget()
            ->formModel(new ErrorSummaryForm())
            ->render();

        $this->assertSame('', $result);
    }
}
