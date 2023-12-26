<?php

declare(strict_types=1);

namespace Field;

namespace Yiisoft\Form\Tests\Field;

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
}
