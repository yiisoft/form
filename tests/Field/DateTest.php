<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\YiisoftFormModel\FormModelInputData;
use Yiisoft\Form\Field\Date;
use Yiisoft\Form\Tests\Support\Form\DateForm;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class DateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $result = Date::widget()
            ->inputData(new FormModelInputData(new DateForm(), 'birthday'))
            ->render();

        $expected = <<<'HTML'
        <div>
        <label for="dateform-birthday">Your birthday</label>
        <input type="date" id="dateform-birthday" name="DateForm[birthday]" value="1996-12-19">
        <div>Birthday date.</div>
        </div>
        HTML;

        $this->assertSame($expected, $result);
    }

    public function testRange(): void
    {
        $result = Date::widget()
            ->inputData(new FormModelInputData(new DateForm(), 'startDate'))
            ->min('1990-01-01')
            ->max('2030-12-31')
            ->render();

        $expected = <<<'HTML'
        <div>
        <label for="dateform-startdate">Date of start</label>
        <input type="date" id="dateform-startdate" name="DateForm[startDate]" min="1990-01-01" max="2030-12-31">
        </div>
        HTML;

        $this->assertSame($expected, $result);
    }
}
