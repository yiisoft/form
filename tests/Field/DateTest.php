<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Date;
use Yiisoft\Form\Tests\Support\AssertTrait;
use Yiisoft\Form\Tests\Support\Form\DateForm;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class DateTest extends TestCase
{
    use AssertTrait;

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testBase(): void
    {
        $result = Date::widget()
            ->attribute(new DateForm(), 'birthday')
            ->render();

        $expected = <<<'HTML'
        <div>
        <label for="dateform-birthday">Your birthday</label>
        <input type="date" id="dateform-birthday" name="DateForm[birthday]" value="1996-12-19">
        <div>Birthday date.</div>
        </div>
        HTML;

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }

    public function testRange(): void
    {
        $result = Date::widget()
            ->attribute(new DateForm(), 'startDate')
            ->min('1990-01-01')
            ->max('2030-12-31')
            ->render();

        $expected = <<<'HTML'
        <div>
        <label for="dateform-startdate">Date of start</label>
        <input type="date" id="dateform-startdate" name="DateForm[startDate]" min="1990-01-01" max="2030-12-31">
        </div>
        HTML;

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }
}
