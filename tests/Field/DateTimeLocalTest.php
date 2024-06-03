<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use DateTime;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\DateTimeLocal;
use Yiisoft\Form\Theme\ThemeContainer;

final class DateTimeLocalTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $inputData = new PureInputData(
            name: 'partyDate',
            value: '2017-06-01T08:30',
            label: 'Date of party',
            hint: 'Party date.',
            id: 'datetimelocalform-partydate',
        );

        $result = DateTimeLocal::widget()->inputData($inputData)->render();

        $expected = <<<HTML
            <div>
            <label for="datetimelocalform-partydate">Date of party</label>
            <input type="datetime-local" id="datetimelocalform-partydate" name="partyDate" value="2017-06-01T08:30">
            <div>Party date.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testWithDateTimeInterface(): void
    {
        $value = (new DateTime('1996-12-19'))->setTime(20, 35);

        $result = DateTimeLocal::widget()->value($value)->render();

        $this->assertSame(
            <<<HTML
            <div>
            <input type="datetime-local" value="1996-12-19T20:35">
            </div>
            HTML,
            $result,
        );
    }
}
