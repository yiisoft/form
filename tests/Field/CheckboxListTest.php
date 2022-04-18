<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\CheckboxList;
use Yiisoft\Form\Tests\Support\AssertTrait;
use Yiisoft\Form\Tests\Support\Form\CheckboxListForm;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class CheckboxListTest extends TestCase
{
    use AssertTrait;

    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testBase(): void
    {
        $result = CheckboxList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->attribute(new CheckboxListForm(), 'color')
            ->render();

        $expected = <<<'HTML'
        <div>
        <label>Select one or more colors</label>
        <div>
        <label><input type="checkbox" name="CheckboxListForm[color][]" value="red"> Red</label>
        <label><input type="checkbox" name="CheckboxListForm[color][]" value="blue"> Blue</label>
        </div>
        <div>Color of box.</div>
        </div>
        HTML;

        $this->assertStringContainsStringIgnoringLineEndings($expected, $result);
    }
}
