<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\YiisoftFormModel\FormModelInputData;
use Yiisoft\Form\Field\DateTime;
use Yiisoft\Form\Tests\Support\Form\DateTimeForm;
use Yiisoft\Form\ThemeContainer;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class DateTimeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $result = DateTime::widget()
            ->inputData(new FormModelInputData(new DateTimeForm(), 'partyDate'))
            ->render();

        $expected = <<<'HTML'
        <div>
        <label for="datetimeform-partydate">Date of party</label>
        <input type="datetime" id="datetimeform-partydate" name="DateTimeForm[partyDate]" value="2017-06-01T08:30">
        <div>Party date.</div>
        </div>
        HTML;

        $this->assertSame($expected, $result);
    }
}
