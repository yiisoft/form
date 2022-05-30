<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\ButtonGroup;
use Yiisoft\Html\Html;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Widget\WidgetFactory;

final class ButtonGroupTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        WidgetFactory::initialize(new SimpleContainer());
    }

    public function testBase(): void
    {
        $result = ButtonGroup::widget()
            ->buttons(
                Html::resetButton('Reset Data'),
                Html::submitButton('Send'),
            )
            ->render();

        $expected = <<<HTML
            <div>
            <button type="reset">Reset Data</button>
            <button type="submit">Send</button>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testButtonsData(): void
    {
        $result = ButtonGroup::widget()
            ->buttonsData([
                ['Reset', 'type' => 'reset', 'class' => 'default'],
                ['Send', 'type' => 'submit', 'class' => 'primary'],
            ])
            ->render();

        $expected = <<<HTML
            <div>
            <button type="reset" class="default">Reset</button>
            <button type="submit" class="primary">Send</button>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testAddButtonAttributes(): void
    {
        $result = ButtonGroup::widget()
            ->buttonsData([
                ['Reset', 'type' => 'reset'],
                ['Send', 'type' => 'submit'],
            ])
            ->addButtonAttributes(['class' => 'button'])
            ->addButtonAttributes(['data-key' => 'x100'])
            ->render();

        $expected = <<<HTML
            <div>
            <button type="reset" class="button" data-key="x100">Reset</button>
            <button type="submit" class="button" data-key="x100">Send</button>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testButtonAttributes(): void
    {
        $result = ButtonGroup::widget()
            ->buttonsData([
                ['Reset', 'type' => 'reset'],
                ['Send', 'type' => 'submit'],
            ])
            ->buttonAttributes(['data-key' => 'x100'])
            ->buttonAttributes(['class' => 'button'])
            ->render();

        $expected = <<<HTML
            <div>
            <button type="reset" class="button">Reset</button>
            <button type="submit" class="button">Send</button>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testDisabled(): void
    {
        $result = ButtonGroup::widget()
            ->buttonsData([
                ['Reset', 'type' => 'reset'],
                ['Send', 'type' => 'submit'],
            ])
            ->disabled()
            ->render();

        $expected = <<<HTML
            <div>
            <button type="reset" disabled>Reset</button>
            <button type="submit" disabled>Send</button>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testForm(): void
    {
        $result = ButtonGroup::widget()
            ->buttonsData([
                ['Reset', 'type' => 'reset'],
                ['Send', 'type' => 'submit'],
            ])
            ->form('CreatePost')
            ->render();

        $expected = <<<HTML
            <div>
            <button type="reset" form="CreatePost">Reset</button>
            <button type="submit" form="CreatePost">Send</button>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testSeparator(): void
    {
        $result = ButtonGroup::widget()
            ->buttonsData([
                ['Reset', 'type' => 'reset'],
                ['Send', 'type' => 'submit'],
            ])
            ->separator("\n<br>\n")
            ->render();

        $expected = <<<HTML
            <div>
            <button type="reset">Reset</button>
            <br>
            <button type="submit">Send</button>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = ButtonGroup::widget();

        $this->assertNotSame($field, $field->buttons());
        $this->assertNotSame($field, $field->buttonsData([]));
        $this->assertNotSame($field, $field->buttonAttributes([]));
        $this->assertNotSame($field, $field->addButtonAttributes([]));
        $this->assertNotSame($field, $field->disabled());
        $this->assertNotSame($field, $field->form('test'));
        $this->assertNotSame($field, $field->separator(''));
    }
}
