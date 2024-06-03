<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\Field;

use PHPUnit\Framework\TestCase;
use Yiisoft\Form\Field\Fieldset;
use Yiisoft\Form\PureField;
use Yiisoft\Form\Theme\ThemeContainer;
use Yiisoft\Html\Tag\Legend;

final class FieldsetTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        ThemeContainer::initialize();
    }

    public function testBase(): void
    {
        $result = Fieldset::widget()->begin()
            . "\n"
            . PureField::text('firstName', '')->useContainer(false)
            . "\n"
            . PureField::text('lastName', '')->useContainer(false)
            . "\n"
            . Fieldset::end();

        $this->assertSame(
            <<<HTML
            <div>
            <fieldset>
            <input type="text" name="firstName" value>
            <input type="text" name="lastName" value>
            </fieldset>
            </div>
            HTML,
            $result
        );
    }

    public function testContent(): void
    {
        $result = Fieldset::widget()
            ->content(
                PureField::text('firstName', '')->useContainer(false),
                "\n",
                PureField::text('lastName', '')->useContainer(false),
            )
            ->render();

        $this->assertSame(
            <<<HTML
            <div>
            <fieldset>
            <input type="text" name="firstName" value>
            <input type="text" name="lastName" value>
            </fieldset>
            </div>
            HTML,
            $result
        );
    }

    public function testLegend(): void
    {
        $result = Fieldset::widget()
            ->legend('test')
            ->render();

        $expected = <<<HTML
            <div>
            <fieldset>
            <legend>test</legend>
            </fieldset>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testLegendTag(): void
    {
        $result = Fieldset::widget()
            ->legendTag(Legend::tag()->content('test'))
            ->render();

        $expected = <<<HTML
            <div>
            <fieldset>
            <legend>test</legend>
            </fieldset>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testDisabled(): void
    {
        $result = Fieldset::widget()
            ->disabled()
            ->render();

        $expected = <<<HTML
            <div>
            <fieldset disabled>
            </fieldset>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testForm(): void
    {
        $result = Fieldset::widget()
            ->form('CreatePost')
            ->render();

        $expected = <<<HTML
            <div>
            <fieldset form="CreatePost">
            </fieldset>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testName(): void
    {
        $result = Fieldset::widget()
            ->name('test')
            ->render();

        $expected = <<<HTML
            <div>
            <fieldset name="test">
            </fieldset>
            </div>
            HTML;

        $this->assertSame($expected, $result);
    }

    public function testImmutability(): void
    {
        $field = Fieldset::widget();

        $this->assertNotSame($field, $field->legend(null));
        $this->assertNotSame($field, $field->legendTag(null));
        $this->assertNotSame($field, $field->disabled());
        $this->assertNotSame($field, $field->form(null));
        $this->assertNotSame($field, $field->name(null));
    }
}
