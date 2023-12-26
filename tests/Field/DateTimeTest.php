<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Base\InputData\PureInputData;
use Yiisoft\Form\Field\DateTime;
use Yiisoft\Form\ThemeContainer;

final class DateTimeTest extends TestCase
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
            id: 'datetimeform-partydate',
        );

        $result = DateTime::widget()->inputData($inputData)->render();

        $expected = <<<HTML
            <div>
            <label for="datetimeform-partydate">Date of party</label>
            <input type="datetime" id="datetimeform-partydate" name="partyDate" value="2017-06-01T08:30">
            <div>Party date.</div>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }
}
