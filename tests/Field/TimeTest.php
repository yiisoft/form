<?php

declare(strict_types=1);

namespace Field;

namespace Yiisoft\Form\Tests\Field;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Time;
use Yiisoft\Form\ThemeContainer;

final class TimeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $html = Time::widget()->render();

        $expected = <<<HTML
            <div>
            <input type="time">
            </div>
            HTML;

        $this->assertSame($expected, $html);
    }

    public function testExtended(): void
    {
        $result = Time::widget()
            ->min('09:00')
            ->max('18:00')
            ->inputId('appt')
            ->name('appt')
            ->required()
            ->render();

        $expected = <<<'HTML'
        <div>
        <input type="time" id="appt" name="appt" min="09:00" max="18:00" required>
        </div>
        HTML;

        $this->assertSame($expected, $result);
    }

    public function testWithDateTimeInterface(): void
    {
        $value = (new DateTimeImmutable('1996-12-19'))->setTime(20, 35);

        $result = Time::widget()->value($value)->render();

        $this->assertSame(
            <<<HTML
            <div>
            <input type="time" value="20:35">
            </div>
            HTML,
            $result,
        );
    }
}
