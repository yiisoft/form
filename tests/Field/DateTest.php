<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use DateTime;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\Date;
use Yiisoft\Form\Theme\ThemeContainer;

final class DateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $inputData = new PureInputData(
            name: 'DateForm[birthday]',
            value: '1996-12-19',
            label: 'Your birthday',
            hint: 'Birthday date.',
            id: 'dateform-birthday',
        );

        $result = Date::widget()->inputData($inputData)->render();

        $expected = <<<HTML
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
            ->name('startDate')
            ->min('1990-01-01')
            ->max('2030-12-31')
            ->render();

        $expected = <<<HTML
            <div>
            <input type="date" name="startDate" min="1990-01-01" max="2030-12-31">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testWithDateTimeInterface(): void
    {
        $result = Date::widget()
            ->value(new DateTime('1996-12-19'))
            ->render();

        $this->assertSame(
            <<<HTML
            <div>
            <input type="date" value="1996-12-19">
            </div>
            HTML,
            $result,
        );
    }
}
