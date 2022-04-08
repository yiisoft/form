<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Range;
use Yiisoft\Form\Tests\Support\AssertTrait;
use Yiisoft\Form\Tests\Support\Form\RangeForm;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class RangeTest extends TestCase
{
    use AssertTrait;

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testWithOutput(): void
    {
        $result = Range::widget()
            ->attribute(new RangeForm(), 'volume')
            ->min(1)
            ->max(100)
            ->showOutput()
            ->outputTagAttributes(['id' => 'UID'])
            ->render();
        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <label for="rangeform-volume">Volume level</label>
            <input type="range" id="rangeform-volume" name="RangeForm[volume]" value="23" min="1" max="100" oninput="document.getElementById(&quot;UID&quot;).innerHTML=this.value">
            <span id="UID">23</span>
            </div>
            HTML,
            $result
        );
    }
}
