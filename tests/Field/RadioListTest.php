<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\RadioList;
use Yiisoft\Form\Tests\Support\Form\RadioListForm;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class RadioListTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testBase(): void
    {
        $result = RadioList::widget()
            ->items([
                'red' => 'Red',
                'blue' => 'Blue',
            ])
            ->attribute(new RadioListForm(), 'color')
            ->render();

        $expected = <<<'HTML'
        <div>
        <label>Select color</label>
        <div>
        <label><input type="radio" name="RadioListForm[color]" value="red"> Red</label>
        <label><input type="radio" name="RadioListForm[color]" value="blue"> Blue</label>
        </div>
        <div>Color of box.</div>
        </div>
        HTML;

        $this->assertSame($expected, $result);
    }
}
