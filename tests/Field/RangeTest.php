<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Range;
use Yiisoft\Form\Tests\Support\Form\RangeForm;
use Yiisoft\Form\Tests\Support\StringableObject;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class RangeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testBase(): void
    {
        $result = Range::widget()
            ->formAttribute(new RangeForm(), 'volume')
            ->min(1)
            ->max(100)
            ->render();

        $expected = <<<HTML
            <div>
            <label for="rangeform-volume">Volume level</label>
            <input type="range" id="rangeform-volume" name="RangeForm[volume]" value="23" min="1" max="100">
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddOutputAttributes(): void
    {
        $result = Range::widget()
            ->formAttribute(new RangeForm(), 'volume')
            ->showOutput()
            ->addOutputAttributes(['class' => 'red'])
            ->addOutputAttributes(['id' => 'UID'])
            ->render();

        $expected = <<<HTML_WRAP
<div>
<label for="rangeform-volume">Volume level</label>
<input type="range" id="rangeform-volume" name="RangeForm[volume]" value="23" oninput="document.getElementById(&quot;UID&quot;).innerHTML=this.value">
<span id="UID" class="red">23</span>
</div>
HTML_WRAP;

        $this->assertSame($expected, $result);
    }

    public function testOutputAttributes(): void
    {
        $result = Range::widget()
            ->formAttribute(new RangeForm(), 'volume')
            ->showOutput()
            ->outputAttributes(['class' => 'red'])
            ->outputAttributes(['id' => 'UID'])
            ->render();

        $expected = <<<HTML_WRAP
<div>
<label for="rangeform-volume">Volume level</label>
<input type="range" id="rangeform-volume" name="RangeForm[volume]" value="23" oninput="document.getElementById(&quot;UID&quot;).innerHTML=this.value">
<span id="UID">23</span>
</div>
HTML_WRAP;

        $this->assertSame($expected, $result);
    }

    public function testWithOutput(): void
    {
        $result = Range::widget()
            ->formAttribute(new RangeForm(), 'volume')
            ->min(1)
            ->max(100)
            ->showOutput()
            ->outputAttributes(['id' => 'UID'])
            ->render();

        $expected = <<<HTML_WRAP
<div>
<label for="rangeform-volume">Volume level</label>
<input type="range" id="rangeform-volume" name="RangeForm[volume]" value="23" min="1" max="100" oninput="document.getElementById(&quot;UID&quot;).innerHTML=this.value">
<span id="UID">23</span>
</div>
HTML_WRAP;

        $this->assertSame($expected, $result);
    }

    public function testCustomOutputTag(): void
    {
        $result = Range::widget()
            ->formAttribute(new RangeForm(), 'volume')
            ->showOutput()
            ->outputTag('div')
            ->outputAttributes(['id' => 'UID'])
            ->render();

        $expected = <<<HTML_WRAP
<div>
<label for="rangeform-volume">Volume level</label>
<input type="range" id="rangeform-volume" name="RangeForm[volume]" value="23" oninput="document.getElementById(&quot;UID&quot;).innerHTML=this.value">
<div id="UID">23</div>
</div>
HTML_WRAP;

        $this->assertSame($expected, $result);
    }

    public function testEmptyOutputTag(): void
    {
        $field = Range::widget();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The output tag name it cannot be empty value.');
        $field->outputTag('');
    }

    public function dataMax(): array
    {
        return [
            'int' => [
                '<input type="range" id="rangeform-count" name="RangeForm[count]" max="42">',
                42,
            ],
            'string' => [
                '<input type="range" id="rangeform-count" name="RangeForm[count]" max="53">',
                '53',
            ],
            'float' => [
                '<input type="range" id="rangeform-count" name="RangeForm[count]" max="5.9">',
                '5.9',
            ],
            'Stringable' => [
                '<input type="range" id="rangeform-count" name="RangeForm[count]" max="7">',
                new StringableObject('7'),
            ],
            'null' => [
                '<input type="range" id="rangeform-count" name="RangeForm[count]">',
                null,
            ],
        ];
    }

    /**
     * @dataProvider dataMax
     */
    public function testMax(string $expected, $value): void
    {
        $result = Range::widget()
            ->formAttribute(new RangeForm(), 'count')
            ->hideLabel()
            ->useContainer(false)
            ->max($value)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function dataMin(): array
    {
        return [
            'int' => [
                '<input type="range" id="rangeform-count" name="RangeForm[count]" min="42">',
                42,
            ],
            'string' => [
                '<input type="range" id="rangeform-count" name="RangeForm[count]" min="53">',
                '53',
            ],
            'float' => [
                '<input type="range" id="rangeform-count" name="RangeForm[count]" min="5.9">',
                '5.9',
            ],
            'Stringable' => [
                '<input type="range" id="rangeform-count" name="RangeForm[count]" min="7">',
                new StringableObject('7'),
            ],
            'null' => [
                '<input type="range" id="rangeform-count" name="RangeForm[count]">',
                null,
            ],
        ];
    }

    /**
     * @dataProvider dataMin
     */
    public function testMin(string $expected, $value): void
    {
        $result = Range::widget()
            ->formAttribute(new RangeForm(), 'count')
            ->hideLabel()
            ->useContainer(false)
            ->min($value)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function dataStep(): array
    {
        return [
            'int' => [
                '<input type="range" id="rangeform-count" name="RangeForm[count]" step="42">',
                42,
            ],
            'string' => [
                '<input type="range" id="rangeform-count" name="RangeForm[count]" step="53">',
                '53',
            ],
            'float' => [
                '<input type="range" id="rangeform-count" name="RangeForm[count]" step="5.9">',
                '5.9',
            ],
            'Stringable' => [
                '<input type="range" id="rangeform-count" name="RangeForm[count]" step="7">',
                new StringableObject('7'),
            ],
            'null' => [
                '<input type="range" id="rangeform-count" name="RangeForm[count]">',
                null,
            ],
        ];
    }

    /**
     * @dataProvider dataStep
     */
    public function testStep(string $expected, $value): void
    {
        $result = Range::widget()
            ->formAttribute(new RangeForm(), 'count')
            ->hideLabel()
            ->useContainer(false)
            ->step($value)
            ->render();

        $this->assertSame($expected, $result);
    }

    public function testList(): void
    {
        $result = Range::widget()
            ->formAttribute(new RangeForm(), 'count')
            ->hideLabel()
            ->useContainer(false)
            ->list('TheList')
            ->render();

        $this->assertSame(
            '<input type="range" id="rangeform-count" name="RangeForm[count]" list="TheList">',
            $result
        );
    }

    public function testDisabled(): void
    {
        $result = Range::widget()
            ->formAttribute(new RangeForm(), 'count')
            ->hideLabel()
            ->useContainer(false)
            ->disabled()
            ->render();

        $this->assertSame(
            '<input type="range" id="rangeform-count" name="RangeForm[count]" disabled>',
            $result
        );
    }

    public function testAriaDescribedBy(): void
    {
        $result = Range::widget()
            ->formAttribute(new RangeForm(), 'count')
            ->hideLabel()
            ->useContainer(false)
            ->ariaDescribedBy('hint')
            ->render();

        $this->assertSame(
            '<input type="range" id="rangeform-count" name="RangeForm[count]" aria-describedby="hint">',
            $result
        );
    }

    public function testAriaLabel(): void
    {
        $result = Range::widget()
            ->formAttribute(new RangeForm(), 'count')
            ->hideLabel()
            ->useContainer(false)
            ->ariaLabel('test')
            ->render();

        $this->assertSame(
            '<input type="range" id="rangeform-count" name="RangeForm[count]" aria-label="test">',
            $result
        );
    }

    public function testAutofocus(): void
    {
        $result = Range::widget()
            ->formAttribute(new RangeForm(), 'count')
            ->hideLabel()
            ->useContainer(false)
            ->autofocus()
            ->render();

        $this->assertSame(
            '<input type="range" id="rangeform-count" name="RangeForm[count]" autofocus>',
            $result
        );
    }

    public function testTabIndex(): void
    {
        $result = Range::widget()
            ->formAttribute(new RangeForm(), 'count')
            ->hideLabel()
            ->useContainer(false)
            ->tabIndex(5)
            ->render();

        $this->assertSame(
            '<input type="range" id="rangeform-count" name="RangeForm[count]" tabindex="5">',
            $result
        );
    }

    public function dataEnrichmentFromRules(): array
    {
        return [
            'required' => [
                '<input type="range" id="rangeform-volume" name="RangeForm[volume]" value="23" required>',
                'volume',
            ],
            'number' => [
                '<input type="range" id="rangeform-count" name="RangeForm[count]" min="1" max="9">',
                'count',
            ],
            'required-with-when' => [
                '<input type="range" id="rangeform-requiredwhen" name="RangeForm[requiredWhen]">',
                'requiredWhen',
            ],
        ];
    }

    /**
     * @dataProvider dataEnrichmentFromRules
     */
    public function testEnrichmentFromRules(string $expected, string $attribute): void
    {
        $field = Range::widget()
            ->formAttribute(new RangeForm(), $attribute)
            ->hideLabel()
            ->useContainer(false)
            ->enrichmentFromRules(true);

        $this->assertSame($expected, $field->render());
    }

    public function testInvalidValue(): void
    {
        $field = Range::widget()
            ->formAttribute(new RangeForm(), 'flag');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Range field requires a string, numeric or null value.');
        $field->render();
    }
}
