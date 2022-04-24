<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Select;
use Yiisoft\Form\Tests\Support\Form\SelectForm;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class SelectTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testBase(): void
    {
        $result = Select::widget()
            ->attribute(new SelectForm(), 'number')
            ->optionsData([
                1 => 'One',
                2 => 'Two',
            ])
            ->render();
        $this->assertSame(
            <<<HTML
            <div>
            <label for="selectform-number">Select number</label>
            <select name="SelectForm[number]">
            <option value="1">One</option>
            <option value="2">Two</option>
            </select>
            </div>
            HTML,
            $result
        );
    }

    public function testSelectedSingle(): void
    {
        $result = Select::widget()
            ->attribute(new SelectForm(), 'count')
            ->optionsData([
                10 => 'Ten',
                15 => 'Fifteen',
                20 => 'Twenty',
            ])
            ->render();
        $this->assertSame(
            <<<HTML
            <div>
            <label for="selectform-count">Select count</label>
            <select name="SelectForm[count]">
            <option value="10">Ten</option>
            <option value="15" selected>Fifteen</option>
            <option value="20">Twenty</option>
            </select>
            </div>
            HTML,
            $result
        );
    }

    public function testSelectedMultiple(): void
    {
        $result = Select::widget()
            ->attribute(new SelectForm(), 'letters')
            ->optionsData([
                'A' => 'Letter A',
                'B' => 'Letter B',
                'C' => 'Letter C',
            ])
            ->multiple()
            ->render();
        $this->assertSame(
            <<<HTML
            <div>
            <label for="selectform-letters">Select letters</label>
            <input type="hidden" name="SelectForm[letters]" value>
            <select name="SelectForm[letters][]" multiple>
            <option value="A" selected>Letter A</option>
            <option value="B">Letter B</option>
            <option value="C" selected>Letter C</option>
            </select>
            </div>
            HTML,
            $result
        );
    }

    public function testImmutability(): void
    {
        $field = Select::widget();

        $this->assertNotSame($field, $field->items());
        $this->assertNotSame($field, $field->options());
        $this->assertNotSame($field, $field->optionsData([]));
        $this->assertNotSame($field, $field->disabled());
        $this->assertNotSame($field, $field->multiple());
        $this->assertNotSame($field, $field->prompt(null));
        $this->assertNotSame($field, $field->promptOption(null));
        $this->assertNotSame($field, $field->required());
        $this->assertNotSame($field, $field->size(4));
        $this->assertNotSame($field, $field->unselectValue(null));
    }
}
