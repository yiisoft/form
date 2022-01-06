<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Factory\NotFoundException;
use Yiisoft\Form\Tests\TestSupport\Form\TypeForm;
use Yiisoft\Form\Tests\TestSupport\TestTrait;
use Yiisoft\Form\Widget\Range;
use Yiisoft\Html\Html;

final class RangeTest extends TestCase
{
    use TestTrait;

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testImmutability(): void
    {
        $range = Range::widget();
        $this->assertNotSame($range, $range->max(0));
        $this->assertNotSame($range, $range->min(0));
        $this->assertNotSame($range, $range->outputAttributes([]));
        $this->assertNotSame($range, $range->outputTag(''));
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMax(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" max="8" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->for(new TypeForm(), 'int')->max(8)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testMin(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" min="4" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->for(new TypeForm(), 'int')->min(4)->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testOutputAttributes(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" oninput="i1.value=this.value">
        <output id="i1" class="test-class" name="i1" for="TypeForm[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->for(new TypeForm(), 'int')->outputAttributes(['class' => 'test-class'])->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testOutputTag(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" oninput="i1.value=this.value">
        <p id="i1" name="i1" for="TypeForm[int]">0</p>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->for(new TypeForm(), 'int')->outputTag('p')->render(),
        );
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testOutputTagException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The output tag name it cannot be empty value.');
        Range::widget()->for(new TypeForm(), 'int')->outputTag('')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testRender(): void
    {
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <input type="range" id="typeform-int" name="TypeForm[int]" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[int]">0</output>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Range::widget()->for(new TypeForm(), 'int')->render(),
        );
    }

    public function testValueException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Range widget must be a numeric or null value.');
        Range::widget()->for(new TypeForm(), 'array')->render();
    }

    /**
     * @throws CircularReferenceException|InvalidConfigException|NotFoundException|NotInstantiableException
     */
    public function testValueWithFormModel(): void
    {
        $formModel = new TypeForm();

        // Value numeric string `1`.
        $formModel->setAttribute('string', '1');
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <input type="range" id="typeform-string" name="TypeForm[string]" value="1" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[string]">1</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for($formModel, 'string')->render());

        // Value int `1`.
        $formModel->setAttribute('int', 1);
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $expected = <<<'HTML'
        <input type="range" id="typeform-int" name="TypeForm[int]" value="1" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[int]">1</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for($formModel, 'int')->render());

        // Value `null`.
        $this->setInaccessibleProperty(new Html(), 'generateIdCounter', []);
        $formModel->setAttribute('string', null);
        $expected = <<<'HTML'
        <input type="range" id="typeform-string" name="TypeForm[string]" value="0" oninput="i1.value=this.value">
        <output id="i1" name="i1" for="TypeForm[string]">0</output>
        HTML;
        $this->assertEqualsWithoutLE($expected, Range::widget()->for($formModel, 'string')->render());
    }
}
