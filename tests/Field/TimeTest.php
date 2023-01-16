<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Time;
use Yiisoft\Form\Tests\Support\Form\TimeForm;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class TimeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testBase(): void
    {
        $result = Time::widget()
            ->formAttribute(new TimeForm(), 'checkinTime')
            ->render();

        $expected = <<<'HTML'
        <div>
        <label for="timeform-checkintime">Check-in time</label>
        <input type="time" id="timeform-checkintime" name="TimeForm[checkinTime]" value="15:00">
        <div>Check-in time.</div>
        </div>
        HTML;

        $this->assertSame($expected, $result);
    }

    public function testRange(): void
    {
        $result = Time::widget()
            ->formAttribute(new TimeForm(), 'startTime')
            ->min('14:00')
            ->max('20:00')
            ->render();

        $expected = <<<'HTML'
        <div>
        <label for="timeform-starttime">Start time</label>
        <input type="time" id="timeform-starttime" name="TimeForm[startTime]" min="14:00" max="20:00>
        </div>
        HTML;

        $this->assertSame($expected, $result);
    }
}
